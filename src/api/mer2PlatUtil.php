<?php
namespace api;
/**
 * 商户请求平台参数处理
 * @author xuchaofu
 *	2010-03-29
 */
Class ReqDataUtil {

	public function getReqData($appname, $map, $funcode, $method) {
		$log     = new Logger();
		$reqData = new ReqData();
		//对请求数据进行有效性验证,并对其进行重新组织
		$data = $this->getData($map, $funcode);
		//获取请求数据签名明文串
		$plain = $this->getPlain($data);
		//获取请求数据签名密文串
		$sign = trim($this->getSign($data));
		$log->logInfo($funcode." method=".$method);
		$log->logInfo($funcode." getReqData sign=".$sign);
		$log->logInfo($funcode." getReqData plain=".$plain);
		//获取GET方式请求数据对象
		if ($method == method_get) {
			//获取平台URL
			$url = $this->getUrl($appname, $funcode);
			//获取密文串
			// 			$sign = urlencode($sign);
			//获取请求参数
			$param = StringUtil::getParameter($data);
			$reqData->setUrl($url."?".$param.'&sign='.urlencode($sign));
			//$url = $this->getParams($appname,$map,$funcode);
			//$reqData->setUrl($url);
			$log->logInfo($funcode." url=".$url."?".$param.'&sign='.$sign);
			//获取POST方式请求数据对象
		} else if ($method == method_post) {
			$url = $this->getUrl($appname, $funcode);
			$log->logInfo($funcode." url=".$url);
			$reqData->setUrl($url);
			$data->put("sign", $sign);
			$reqData->setField($data);
		} else {
			die("未找到".$method."类型处理类");
		}
		$reqData->setPlain($plain);
		$reqData->setSign($sign);
		return $reqData;
	}

	/**
	 * 返回组装好的数据给商户
	 * @param unknown_type $appname
	 * @param unknown_type $map
	 * @param unknown_type $method
	 * @return ReqData
	 */
	public function getRequestData($appname, $map, $method) {
		$log     = new Logger();
		$funcode = StringUtil::trim($map->get("service"));
		$reqData = new ReqData();
		//对请求数据进行有效性验证,并对其进行重新组织
		$req  = new MerToPlatFactory();
		$data = $req->getData($map);
		//获取请求数据签名明文串
		$plain = $this->getSortPlain($data);
		//获取请求数据签名密文串
		$sign = $this->getSignData($data);
		$log->logInfo(" method=".$method);
		$log->logInfo(" getRequestData sign=".$sign);
		$log->logInfo(" getRequestData plain=".$plain);
		//获取GET方式请求数据对象
		if ($method == method_get) {
			//$url = $this->getSortParams ($appname, $map);
			//$reqData->setUrl ( $url );
			//$log->logInfo (" url=" . $url );
			//获取平台URL
			$url = $this->getUrlForV4($appname);
			//获取密文串
			//$sign = urlencode($this->getSign($reqData));
			//获取请求参数
			$param = StringUtil::getSortParameter($data);
			$reqData->setUrl($url."?".$param.'&sign='.urlencode($sign));
			//$url = $this->getParams($appname,$map,$funcode);
			//$reqData->setUrl($url);
			$log->logInfo($funcode." url=".$url."?".$param.'&sign='.$sign);
			// $url = $this->getUrlForV4($appname);
			//获取密文串
			//获取请求参数
			//$param = StringUtil::getSortParameter($reqData);
			//return $url . "?" . $param . '&sign=' . $sign;
			//获取POST方式请求数据对象
		} else if ($method == method_post) {
			$url = $this->getUrlForV4($appname);
			$log->logInfo(" url=".$url);
			$reqData->setUrl($url);
			$data->put("sign", $sign);
			$reqData->setField($data);
		} else {
			die("未找到".$method."类型处理类");
		}
		$reqData->setPlain($plain);
		$reqData->setSign($sign);
		return $reqData;
	}
	/**
	 * 返回组装好的数据给商户
	 * @param unknown_type $appname
	 * @param unknown_type $map
	 * @param unknown_type $method
	 * @return ReqData
	 */
	public function makeRequestData($appname, $map, $method) {
		$mp      = new HashMap();
		$mp      = clone$map;
		$log     = new Logger();
		$funcode = StringUtil::trim($mp->get("service"));
		$log->logInfo("Request platform service=".$funcode);
		$reqData = new ReqData();
		//对请求数据进行有效性验证
		CheckReqDataAndEncrypt::doCheck($mp);
		//敏感字段加密
		$mp = CheckReqDataAndEncrypt::doEncrypt($mp);
		//获取请求数据签名明文串
		$plain = $this->getSortPlain($mp);
		//获取请求数据签名密文串
		$sign = $this->getSignData($mp);
		$log->logInfo("Request platform way=".$method);
		$log->logInfo("Request platform signature string=".$sign);
		$log->logInfo("Clear information request platform=".$plain);
		//获取GET方式请求数据对象
		if ($method == method_get) {
			//获取平台URL
			$url = $this->getUrlForV4($appname);
			//获取请求参数
			$param = StringUtil::getSortParameter($mp);
			$reqData->setUrl($url."?".$param.'&sign='.urlencode($sign));
			$log->logInfo("The service ".$funcode." request platform to get the address url=".$url."?".$param.'&sign='.$sign);
			//获取POST方式请求数据对象
		} else if ($method == method_post) {
			$url = $this->getUrlForV4($appname);
			$log->logInfo("The service ".$funcode." request platform to post the address url=".$url);
			$reqData->setUrl($url);
			$mp->put("sign", $sign);
			$reqData->setField($mp);
		} else {
			die("Not found ".$method."type processing class");
		}
		$reqData->setPlain($plain);
		$reqData->setSign($sign);
		return $reqData;
	}
	private function getData($map, $funcode) {
		$data = new HashMap();
		switch ($funcode) {
			case funcode_webReqPay://统一支付下单
				$req  = new WebReqPayData();
				$data = $req->getData($map);
				break;
			case funcode_webDirectWyPay://网银直连下单
				$req  = new ReqWyPayData();
				$data = $req->getData($map);
				break;
			case funcode_directPay://后台直连下单
				$req  = new DirectPayData();
				$data = $req->getData($map);
				break;
			case funcode_queryTrans://订单查询
				$req  = new QueryTransData();
				$data = $req->getData($map);
				break;
			case funcode_merCancel://统一支付撤销
				$req  = new MerCancelData();
				$data = $req->getData($map);
				break;
			case funcode_merRefund://退费
				$req  = new MerRefundData();
				$data = $req->getData($map);
				break;
			case funcode_transBill://获取交易数据对帐文件
				$req  = new TransBillData();
				$data = $req->getData($map);
				break;
			case funcode_settleBill://获取清算数据对帐文件
				$req  = new SettleBillData();
				$data = $req->getData($map);
				break;
			case funcode_microPayReq://微支付下单
				$req  = new WebReqPayData();
				$data = $req->getData($map);
				break;
			case funcode_microPayCancel://微支付撤销
				$req  = new MerCancelData();
				$data = $req->getData($map);
				break;
			case funcode_billFileHf://获取话费数据对帐文件
				$req  = new TransBillData();
				$data = $req->getData($map);
				break;
			default:
				die("未找到对应的数据处理类");
		}
		return $data;
	}

	/**
	 * 根据功能码获取平台地址
	 * @param $funcode
	 */
	private static function getUrl($appname, $funcode) {
		$url_map = StringUtil::getCompartKeyAndVal(umpay_urls);
		return plat_url."/".$appname.$url_map->get($funcode);
	}
	/**
	 * V4.0根据功能码获取平台地址
	 * @param $funcode
	 */
	private static function getUrlForV4($appname) {
		return plat_url."/".$appname.umpay_url;
	}
	/**
	 * 根据功能码获取签名明文串
	 * @param $funcode
	 */
	private function getPlain($map) {
		$plain = StringUtil::getPlainByAnd($map);
		return $plain;
	}
	/**
	 * 4.0根据功能码获取签名明文串
	 * @param $funcode
	 */
	private function getSortPlain($map) {
		$plain = StringUtil::getPlainSortAndByAnd($map);
		return $plain;
	}
	/**
	 * 获取签名密文串
	 * @param $map
	 * @param $funcode
	 */
	private function getSign($map) {
		$plain = $this->getPlain($map);
		$sign  = SignUtil::sign($plain);
		return $sign;
	}
	/**
	 * 4.0获取签名密文串
	 * @param $map
	 * @param $funcode
	 */
	private function getSignData($map) {
		$log   = new Logger();
		$plain = $this->getSortPlain($map);
		$merId = $map->get('mer_id');
		$log->logInfo("Participate in the signature parameters：[".$plain."],Merchant number is：[".$merId."]");
		$sign = SignUtil::sign2($plain, $merId);
		return $sign;
	}
	private function getParams($appname, $map, $funcode) {
		//对请求数据进行校验与重组
		$reqData = $this->getData($map, $funcode);
		//获取平台URL
		$url = $this->getUrl($appname, $funcode);
		//获取密文串
		$sign = urlencode($this->getSign($reqData));
		//获取请求参数
		$param = StringUtil::getParameter($reqData);
		return $url."?".$param.'&sign='.$sign;
	}
	/**
	 * 拼装以GET方式提交的URL
	 * @param unknown_type $appname
	 * @param unknown_type $map
	 * @return string
	 */
	private function getSortParams($appname, $map) {
		//对请求数据进行校验与重组
		$req     = new MerToPlatFactory();
		$reqData = $req->getData($map);
		//获取平台URL
		$url = $this->getUrlForV4($appname);
		//获取密文串
		$sign = urlencode($this->getSignData($reqData));
		//获取请求参数
		$param = StringUtil::getSortParameter($reqData);
		return $url."?".$param.'&sign='.$sign;
	}
}

/**
 * API请求数据包装类
 * @author xuchaofu
 *	2010-03-29
 */
Class ReqData {
	private $url;
	private $field;
	private $sign;
	private $plain;

	function setUrl($url) {
		$this->url = $url;
	}

	function setField($field) {
		$this->field = $field;
	}

	function setSign($sign) {
		$this->sign = $sign;
	}

	function setPlain($plain) {
		$this->plain = $plain;
	}

	function getUrl() {
		return $this->url;
	}

	function getField() {
		return $this->field;
	}

	function getSign() {
		return $this->sign;
	}
	function getPlain() {
		return $this->plain;
	}
}

/**
 * 统一支付下单请求数据组织
 * @author xuchaofu
 * 	2010-04-01
 */
Class WebReqPayData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$amount = StringUtil::trim($map->get("amount"));
		if ("" == $amount || strlen($amount) > 13) {die("amount为空或者长度超过限制");
		}

		$amtType = StringUtil::trim($map->get("amtType"));
		if ("" == $amtType || strlen($amtType) != 2) {die("amtType为空或者长度不符合要求");
		}

		$retUrl = StringUtil::trim($map->get("retUrl"));
		if ("" == $retUrl || strlen($retUrl) > 128) {die("retUrl为空或者长度超过限制");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		if (!is_null($map->get("goodsId"))) {
			$goodsId = StringUtil::trim($map->get("goodsId"));
			if (strlen($goodsId) > 8) {die("goodsId长度不符合要求");
			}

			$data->put("goodsId", $goodsId);
		}
		if (!is_null($map->get("goodsInf"))) {
			$goodsInf = StringUtil::trim($map->get("goodsInf"));
			if (strlen($goodsInf) > 128) {die("goodsInf长度不符合要求");
			}

			$data->put("goodsInf", $goodsInf);
		}
		if (!is_null($map->get("mobileId"))) {
			$mobileId = StringUtil::trim($map->get("mobileId"));
			if ("" != $mobileId && strlen($mobileId) != 11) {die("mobileId长度不符合要求");
			}

			$data->put("mobileId", $mobileId);
		}
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("amount", $amount);
		$data->put("amtType", $amtType);
		if (!is_null($map->get("bankType"))) {
			$bankType = StringUtil::trim($map->get("bankType"));
			if (strlen($bankType) > 16) {die("bankType长度不符合要求");
			}

			$data->put("bankType", $bankType);
		}
		if (!is_null($map->get("gateId"))) {
			$gateId = StringUtil::trim($map->get("gateId"));
			if (strlen($gateId) > 16) {die("gateId长度不符合要求");
			}

			$data->put("gateId", $gateId);
		}
		$data->put("retUrl", $retUrl);
		if (!is_null($map->get("notifyUrl"))) {
			$notifyUrl = StringUtil::trim($map->get("notifyUrl"));
			if (strlen($notifyUrl) > 128) {die("notifyUrl长度不符合要求");
			}

			$data->put("notifyUrl", $notifyUrl);
		}
		if (!is_null($map->get("merPriv"))) {
			$merPriv = StringUtil::trim($map->get("merPriv"));
			if (strlen($merPriv) > 64) {die("merPriv长度不符合要求");
			}

			$data->put("merPriv", $merPriv);
		}
		if (!is_null($map->get("expand"))) {
			$expand = StringUtil::trim($map->get("expand"));
			if (strlen($expand) > 128) {die("expand长度不符合要求");
			}

			$data->put("expand", $expand);
		}
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 网银直连下单请求数据组织
 * @author xuchaofu
 * 	2010-04-01
 */
Class ReqWyPayData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$amount = StringUtil::trim($map->get("amount"));
		if ("" == $amount || strlen($amount) > 13) {die("amount为空或者长度超过限制");
		}

		$amtType = StringUtil::trim($map->get("amtType"));
		if ("" == $amtType || strlen($amtType) != 2) {die("amtType为空或者长度不符合要求");
		}

		$retUrl = StringUtil::trim($map->get("retUrl"));
		if ("" == $retUrl || strlen($retUrl) > 128) {die("retUrl为空或者长度超过限制");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		if (!is_null($map->get("goodsId"))) {
			$goodsId = StringUtil::trim($map->get("goodsId"));
			if (strlen($goodsId) > 8) {die("goodsId长度不符合要求");
			}

			$data->put("goodsId", $goodsId);
		}
		if (!is_null($map->get("goodsInf"))) {
			$goodsInf = StringUtil::trim($map->get("goodsInf"));
			if (strlen($goodsInf) > 128) {die("goodsInf长度不符合要求");
			}

			$data->put("goodsInf", $goodsInf);
		}
		if (!is_null($map->get("mobileId"))) {
			$mobileId = StringUtil::trim($map->get("mobileId"));
			if ("" != $mobileId && strlen($mobileId) != 11) {die("mobileId长度不符合要求");
			}

			$data->put("mobileId", $mobileId);
		}
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("amount", $amount);
		$data->put("amtType", $amtType);
		if (!is_null($map->get("bankType"))) {
			$bankType = StringUtil::trim($map->get("bankType"));
			if (strlen($bankType) > 16) {die("bankType长度不符合要求");
			}

			$data->put("bankType", $bankType);
		}
		if (!is_null($map->get("gateId"))) {
			$gateId = StringUtil::trim($map->get("gateId"));
			if (strlen($gateId) > 16) {die("gateId长度不符合要求");
			}

			$data->put("gateId", $gateId);
		}
		$data->put("retUrl", $retUrl);
		if (!is_null($map->get("notifyUrl"))) {
			$notifyUrl = StringUtil::trim($map->get("notifyUrl"));
			if (strlen($notifyUrl) > 128) {die("notifyUrl长度不符合要求");
			}

			$data->put("notifyUrl", $notifyUrl);
		}
		if (!is_null($map->get("merPriv"))) {
			$merPriv = StringUtil::trim($map->get("merPriv"));
			if (strlen($merPriv) > 64) {die("merPriv长度不符合要求");
			}

			$data->put("merPriv", $merPriv);
		}
		if (!is_null($map->get("expand"))) {
			$expand = StringUtil::trim($map->get("expand"));
			if (strlen($expand) > 128) {die("expand长度不符合要求");
			}

			$data->put("expand", $expand);
		}
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 商户提交的请求数据进行校验
 * @author 朱锦飞
 * 2010-04-01
 */
class MerToPlatDataProcessor {

	/**
	 * V4.0对商户提交的参数进行校验，最终返回一个提交给平台的HashMap
	 * @param HashMap $param 商户提交的参数
	 * @param HashMap $fields1 必填的参数
	 * @param HashMap $fields2 非必填参数
	 */
	public static function getData($param, $fields1, $fields2) {
		//需要进行日期校验的参数
		$field_date = new HashMap();
		$field_date->put("settle_date", "settle_date");
		$field_date->put("mer_date", "mer_date");
		$field_date->put("payDate", "payDate");
		//需要进行RAS加密的参数
		$field_ras = new HashMap();
		$field_ras->put("card_id", "card_id");
		$field_ras->put("valid_date", "valid_date");
		$field_ras->put("cvv2", "cvv2");
		$field_ras->put("pass_wd", "pass_wd");
		$field_ras->put("identity_code", "identity_code");
		$field_ras->put("card_holder", "card_holder");
		//付款请求添加RAS加密的参数
		$field_ras->put("recv_account", "recv_account");
		$field_ras->put("recv_user_name", "recv_user_name");
		$field_ras->put("identity_holder", "identity_holder");
		$data = new HashMap();
		if ((!$fields1->isEmpty()) && ($fields1->size() > 0)) {
			$keys = $fields1->keys();
			foreach ($keys as $key) {
				$value  = StringUtil::trim($param->get($key));
				$length = StringUtil::trim($fields1->get($key));
				$flag   = $field_date->containsKey($key);
				$flag1  = $field_ras->containsKey($key);
				if ($flag1) {
					if ("" == $value) {
						die($key."为空或者长度超过限制");
					} else {
						$value = iconv("UTF-8", "GBK", $value);
						$value = RSACryptUtil::encrypt($value);
						$data->put($key, $value);
					}
				} elseif ($flag) {
					if (!DateUtil::checkData($value)) {
						die($key."为空或者长度不符合要求");
					} else {

						$data->put($key, $value);
					}
				} elseif ("split_data" == $key) {
					if ("" == $value) {
						die($key."为空或者长度超过限制");
					} else {

						$data->put($key, $value);
					}
				} else {
					if ("" == $value || strlen($value) > $length) {
						die($key."为空或者长度超过限制");
					} else {

						$data->put($key, $value);
					}
				}
			}

			$keys1 = $fields2->keys();
			foreach ($keys1 as $key) {
				if (!is_null($param->get($key))) {
					$value  = StringUtil::trim($param->get($key));
					$length = StringUtil::trim($fields2->get($key));
					$flag1  = $field_ras->containsKey($key);
					if ($flag1) {
						if ("" != $value) {
							if (strlen($value) > $length) {
								die($key."为空或者长度超过限制");
							} else {
								$value = iconv("UTF-8", "GBK", $value);
								$value = RSACryptUtil::encrypt($value);
								$data->put($key, $value);
							}
						}
					} elseif ($field_date->containsKey($key)) {
						if (!DateUtil::checkData($value)) {
							die($key."为空或者长度不符合要求");
						} else {

							$data->put($key, $value);
						}
					} elseif ("split_data" == $key) {
						if ("" != $value) {
							$data->put($key, $value);
						}
					} else {
						if ("" != $value) {
							if (strlen($value) > $length) {
								die($key."为空或者长度超过限制");
							}
						} else {

							$data->put($key, $value);
						}
					}
				}
			}
		} else {
			die("获取请求参数字符串失败:传入参数为空!");
		}
		return $data;
	}

}
/**
 * 工厂类
 * @author 朱锦飞
 * 2010-04-01
 */
class MerToPlatFactory {
	/**
	 * 此方法会根据商户提交参数中的service 取相对应接口所需的参数字段，以便校验使用
	 * @param HashMap $map
	 * @return HashMap
	 */
	public static function getData($map) {
		$service = StringUtil::trim($map->get("service"));
		if ("" == $service || strlen($service) > 32) {
			die("service为空或者长度超过限制");
		}

		if ("pay_req_split_front" == $service || "pay_req_split_back" == $service || "pay_req_split_direct" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_req_split);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_req_split1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("credit_direct_pay" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(credit_direct_pay);
			$fields2 = StringUtil::getCompartKeyAndVal(credit_direct_pay1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("debit_direct_pay" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(debit_direct_pay);
			$fields2 = StringUtil::getCompartKeyAndVal(debit_direct_pay1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("split_req" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(split_req);
			$fields2 = StringUtil::getCompartKeyAndVal(split_req1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("split_refund_req" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(split_refund_req);
			$fields2 = StringUtil::getCompartKeyAndVal(split_refund_req1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_req_ivr_call" == $service || "pay_req_ivr_tcall" == $service || "pay_req" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_req);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_req1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("query_order" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(query_order);
			$fields2 = StringUtil::getCompartKeyAndVal(query_order1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("mer_cancel" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(mer_cancel);
			$fields2 = StringUtil::getCompartKeyAndVal(mer_cancel1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("mer_refund" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(mer_refund);
			$fields2 = StringUtil::getCompartKeyAndVal(mer_refund1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("download_settle_file" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(download_settle_file);
			$fields2 = StringUtil::getCompartKeyAndVal(download_settle_file1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_guide" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_guide);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_guide1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_confirm" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_confirm);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_confirm1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("req_sms_verifycode" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(req_sms_verifycode);
			$fields2 = StringUtil::getCompartKeyAndVal(req_sms_verifycode1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_req_shortcut_front" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_req_shortcut_front);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_req_shortcut_front1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("transfer_direct_req" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(transfer_direct_req);
			$fields2 = StringUtil::getCompartKeyAndVal(transfer_direct_req1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("transfer_query" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(transfer_query);
			$fields2 = StringUtil::getCompartKeyAndVal(transfer_query1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_req_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_req_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_req_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("query_account_balance" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(query_account_balance);
			$fields2 = StringUtil::getCompartKeyAndVal(query_account_balance1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("req_smsverify_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(req_smsverify_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(req_smsverify_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("pay_confirm_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(pay_confirm_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(pay_confirm_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("first_pay_confirm_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(first_pay_confirm_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(first_pay_confirm_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("agreement_pay_confirm_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(agreement_pay_confirm_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(agreement_pay_confirm_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("req_bind_verify_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(req_bind_verify_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(req_bind_verify_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("req_bind_confirm_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(req_bind_confirm_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(req_bind_confirm_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("query_mer_bank_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(query_mer_bank_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(query_mer_bank_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("query_mercust_bank_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(query_mercust_bank_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(query_mercust_bank_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("unbind_mercust_protocol_shortcut" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(unbind_mercust_protocol_shortcut);
			$fields2 = StringUtil::getCompartKeyAndVal(unbind_mercust_protocol_shortcut1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("query_split_order" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(query_split_order);
			$fields2 = StringUtil::getCompartKeyAndVal(query_split_order1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("card_auth" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(card_auth);
			$fields2 = StringUtil::getCompartKeyAndVal(card_auth1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("mer_order_info_query" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(mer_order_info_query);
			$fields2 = StringUtil::getCompartKeyAndVal(mer_order_info_query1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} elseif ("mer_refund_query" == $service) {
			$fields1 = StringUtil::getCompartKeyAndVal(mer_refund_query);
			$fields2 = StringUtil::getCompartKeyAndVal(mer_refund_query1);
			return MerToPlatDataProcessor::getData($map, $fields1, $fields2);
		} else {
			die("未找到对应的数据处理类");
		}
	}
}
/**
 * 后台下连下单数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class DirectPayData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$goodsId = StringUtil::trim($map->get("goodsId"));
		if ("" == $goodsId || strlen($goodsId) > 8) {die("goodsId为空或者长度超过限制");
		}

		$mobileId = StringUtil::trim($map->get("mobileId"));
		if ("" == $mobileId || strlen($mobileId) != 11) {die("mobileId为空或者长度不符合要求");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$amount = StringUtil::trim($map->get("amount"));
		if ("" == $amount || strlen($amount) > 13) {die("amount为空或者长度超过限制");
		}

		$amtType = StringUtil::trim($map->get("amtType"));
		if ("" == $amtType || strlen($amtType) != 2) {die("amtType为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		$data->put("goodsId", $goodsId);
		$data->put("mobileId", $mobileId);
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("amount", $amount);
		$data->put("amtType", $amtType);

		if (!is_null($map->get("bankType"))) {
			$bankType = StringUtil::trim($map->get("bankType"));
			if (strlen($bankType) > 16) {die("bankType长度不符合要求");
			}

			$data->put("bankType", $bankType);
		}
		if (!is_null($map->get("notifyUrl"))) {
			$notifyUrl = StringUtil::trim($map->get("notifyUrl"));
			if (strlen($notifyUrl) > 128) {die("notifyUrl长度不符合要求");
			}

			$data->put("notifyUrl", $notifyUrl);
		}
		if (!is_null($map->get("merPriv"))) {
			$merPriv = StringUtil::trim($map->get("merPriv"));
			if (strlen($merPriv) > 64) {die("merPriv长度不符合要求");
			}

			$data->put("merPriv", $merPriv);
		}
		if (!is_null($map->get("expand"))) {
			$expand = StringUtil::trim($map->get("expand"));
			if (strlen($expand) > 128) {die("expand长度不符合要求");
			}

			$data->put("expand", $expand);
		}
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 订单查询数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class QueryTransData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		if (!is_null($map->get("goodsId"))) {
			$goodsId = StringUtil::trim($map->get("goodsId"));
			if (strlen($goodsId) > 8) {die("goodsId长度不符合要求");
			}

			$data->put("goodsId", $goodsId);
		}
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		if (!is_null($map->get("mobileId"))) {
			$mobileId = StringUtil::trim($map->get("mobileId"));
			if ("" != $mobileId && strlen($mobileId) != 11) {die("mobileId长度不符合要求");
			}

			$data->put("mobileId", $mobileId);
		}
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 撤销交易数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class MerCancelData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$amount = StringUtil::trim($map->get("amount"));
		if ("" == $amount || strlen($amount) > 13) {die("amount为空或者长度超过限制");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("amount", $amount);
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 商户退费数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class MerRefundData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$refundNo = StringUtil::trim($map->get("refundNo"));
		if ("" == $refundNo || strlen($refundNo) > 16) {die("refundNo为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$amount = StringUtil::trim($map->get("amount"));
		if ("" == $amount || strlen($amount) > 13) {die("amount为空或者长度超过限制");
		}

		$payAmount = StringUtil::trim($map->get("payAmount"));
		if ("" == $payAmount || strlen($payAmount) > 13) {die("payAmount为空或者长度超过限制");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		$data->put("refundNo", $refundNo);
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("amount", $amount);
		$data->put("payAmount", $payAmount);
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 交易数据对帐文件下载请求数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class TransBillData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$payDate = StringUtil::trim($map->get("payDate"));
		if (!DateUtil::checkData($payDate)) {die("payDate为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		$data->put("payDate", $payDate);
		$data->put("version", $version);
		return $data;
	}
}
/**
 * 清算数据对帐文件下载请求数据组织
 * @author xuchaofu
 *	2010-04-01
 */
Class SettleBillData {
	public function getData($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$settleDate = StringUtil::trim($map->get("settleDate"));
		if (!DateUtil::checkData($settleDate)) {die("settleDate为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		$data->put("settleDate", $settleDate);
		$data->put("version", $version);
		return $data;
	}
}

/**
 * 支付结果通知商户响应平台数据处理类
 * @author xuchaofu
 * 	2010-04-02
 */
Class NotifyResData {
	/**
	 * 3.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param unknown_type $map
	 * @return 签名明文串,使用|符号组织签名明文串，如：9996|100|3.0
	 */
	public static function getNotifyResDataPlain($map) {
		$data  = new HashMap();
		$merId = StringUtil::trim($map->get("merId"));
		if ("" == $merId || strlen($merId) > 8) {die("merId为空或者长度超过限制");
		}

		$orderId = StringUtil::trim($map->get("orderId"));
		if ("" == $orderId || strlen($orderId) > 32) {die("orderId为空或者长度超过限制");
		}

		$merDate = StringUtil::trim($map->get("merDate"));
		if (!DateUtil::checkData($merDate)) {die("merDate为空或者长度不符合要求");
		}

		$retCode = StringUtil::trim($map->get("retCode"));
		if ("" == $retCode || strlen($retCode) != 4) {die("retCode为空或者长度不符合要求");
		}

		$retMsg = StringUtil::trim($map->get("retMsg"));
		if ("" == $retMsg || strlen($retMsg) > 128) {die("retMsg为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {die("version为空或者长度不符合要求");
		}

		$data->put("merId", $merId);
		if (!is_null($map->get("goodsId"))) {
			$goodsId = StringUtil::trim($map->get("goodsId"));
			if (strlen($goodsId) > 8) {die("goodsId长度不符合要求");
			}

			$data->put("goodsId", $goodsId);
		}
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("retCode", $retCode);
		$data->put("retMsg", $retMsg);
		$data->put("version", $version);
		return StringUtil::getPlainByLine($map);
	}

	/**
	 * 4.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param HashMap $map
	 * @return 签名明文串,使用&符号组织签名明文串，如：mer_id=9996&amount=100
	 */
	public static function getNotifyResponseDataPlain($map) {
		return StringUtil::getPlainSortAndByAnd($map);
	}
	/**
	 * 4.0接口商户响应平台退款结果通知，检查数据字段合法性并生成签名明文串
	 * @param HashMap $map
	 * @return 签名明文串,使用&符号组织签名明文串，如：mer_id=9996&amount=100
	 */
	public static function getRefundNotifyResponseDataPlain($map) {
		$data   = new HashMap();
		$mer_id = StringUtil::trim($map->get("mer_id"));
		if ("" == $mer_id || strlen($mer_id) > 8) {
			die("mer_id为空或者长度超过限制");
		}

		$ret_code = StringUtil::trim($map->get("ret_code"));
		if ("" == $ret_code || strlen($ret_code) != 4) {
			die("ret_code为空或者长度不符合要求");
		}

		$sign_type = StringUtil::trim($map->get("sign_type"));
		if ("" == $sign_type || strlen($sign_type) > 8) {
			die("sign_type为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {
			die("version为空或者长度不符合要求");
		}

		if (!is_null($map->get("ret_msg"))) {
			$ret_msg = StringUtil::trim($map->get("ret_msg"));
			if (strlen($ret_msg) > 128) {
				die("ret_msg长度不符合要求");
			}

			$data->put("ret_msg", $ret_msg);
		}
		if (!is_null($map->get("mer_trace"))) {
			$mer_trace = StringUtil::trim($map->get("mer_trace"));
			if (strlen($mer_trace) > 32) {
				die("mer_trace长度不符合要求");
			}

			$data->put("mer_trace", $mer_trace);
		}
		if (!is_null($map->get("mer_check_date"))) {
			$mer_check_date = StringUtil::trim($map->get("mer_check_date"));
			if (!DateUtil::checkData($mer_check_date)) {
				die("mer_check_date长度不符合要求");
			}

			$data->put("mer_check_date", $mer_check_date);
		}
		$data->put("mer_id", $mer_id);
		$data->put("ret_code", $ret_code);
		$data->put("sign_type", $sign_type);
		$data->put("version", $version);
		return StringUtil::getPlainSortAndByAnd($map);
	}

	/**
	 * 4.0接口商户响应平台分账请求结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param HashMap $map
	 * @return 签名明文串,使用&符号组织签名明文串，如：mer_id=9996&amount=100
	 */
	public static function getSplitRequestNotifyResDataPlain($map) {
		$data   = new HashMap();
		$mer_id = StringUtil::trim($map->get("mer_id"));
		if ("" == $mer_id || strlen($mer_id) > 8) {
			die("mer_id为空或者长度超过限制");
		}

		$order_id = StringUtil::trim($map->get("order_id"));
		if ("" == $order_id || strlen($order_id) > 32) {
			die("order_id为空或者长度超过限制");
		}

		$mer_date = StringUtil::trim($map->get("mer_date"));
		if (!DateUtil::checkData($mer_date)) {
			die("mer_date为空或者长度不符合要求");
		}

		$ret_code = StringUtil::trim($map->get("ret_code"));
		if ("" == $ret_code || strlen($ret_code) != 4) {
			die("ret_code为空或者长度不符合要求");
		}

		$sign_type = StringUtil::trim($map->get("sign_type"));
		if ("" == $sign_type || strlen($sign_type) > 8) {
			die("sign_type为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {
			die("version为空或者长度不符合要求");
		}

		if (!is_null($map->get("ret_msg"))) {
			$ret_msg = StringUtil::trim($map->get("ret_msg"));
			if (strlen($ret_msg) > 128) {
				die("ret_msg长度不符合要求");
			}

			$data->put("ret_msg", $ret_msg);
		}
		$data->put("mer_id", $mer_id);
		$data->put("order_id", $order_id);
		$data->put("mer_date", $mer_date);
		$data->put("ret_code", $ret_code);
		$data->put("sign_type", $sign_type);
		$data->put("version", $version);
		return StringUtil::getPlainSortAndByAnd($map);
	}

	/**
	 * 4.0接口商户响应平台分账退费结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param unknown_type $map
	 * @return 签名明文串,使用&符号组织签名明文串，如：mer_id=9996&amount=100
	 */
	public static function getSplitMerRefundNotifyResDataPlain($map) {
		$data   = new HashMap();
		$mer_id = StringUtil::trim($map->get("mer_id"));
		if ("" == $mer_id || strlen($mer_id) > 8) {
			die("mer_id为空或者长度超过限制");
		}

		$order_id = StringUtil::trim($map->get("order_id"));
		if ("" == $order_id || strlen($order_id) > 32) {
			die("order_id为空或者长度超过限制");
		}

		$refund_no = StringUtil::trim($map->get("refund_no"));
		if ("" == $refund_no || strlen($refund_no) > 16) {
			die("refund_no为空或者长度超过限制");
		}

		$mer_date = StringUtil::trim($map->get("mer_date"));
		if (!DateUtil::checkData($mer_date)) {
			die("mer_date为空或者长度不符合要求");
		}

		$ret_code = StringUtil::trim($map->get("ret_code"));
		if ("" == $ret_code || strlen($ret_code) != 4) {
			die("ret_code为空或者长度不符合要求");
		}

		$sign_type = StringUtil::trim($map->get("sign_type"));
		if ("" == $sign_type || strlen($sign_type) > 8) {
			die("sign_type为空或者长度不符合要求");
		}

		$version = StringUtil::trim($map->get("version"));
		if ("" == $version || strlen($version) != 3) {
			die("version为空或者长度不符合要求");
		}

		if (!is_null($map->get("ret_msg"))) {
			$ret_msg = StringUtil::trim($map->get("ret_msg"));
			if (strlen($ret_msg) > 128) {
				die("ret_msg长度不符合要求");
			}

			$data->put("ret_msg", $ret_msg);
		}
		$data->put("refund_no", $refund_no);
		$data->put("mer_id", $mer_id);
		$data->put("order_id", $order_id);
		$data->put("mer_date", $mer_date);
		$data->put("ret_code", $ret_code);
		$data->put("sign_type", $sign_type);
		$data->put("version", $version);
		return StringUtil::getPlainSortAndByAnd($map);
	}
}
?>