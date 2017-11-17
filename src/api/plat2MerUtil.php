<?php
namespace api;
/**
 * 平台响应数据解析类
 * @author xuchaofu
 * 	2010-03-31
 *
 */
Class PlatToMerUtil {
	/**
	 * 解析平台响应数据
	 * @param $meta	待解析字符串
	 * @param $patt	各字段对应的字段值
	 * @return 返回解析结果,数据类型:HashMap
	 */
	public static function getDataByMeta($meta, $patt) {
		$log = new Logger();
		$log->logInfo("plat response mer data:".$meta);
		$log->logInfo("interface fields:".$patt);
		$map = new HashMap();
		if (StringUtil::isNull($meta)) {
			$log->logInfo("解析失败:待解析的数据格式错误!");
			die("解析失败:待解析的数据格式错误!");
		}
		//对请响应数据进行验签
		$plain = self::getPlain($meta);
		$sign  = self::getSign($meta);
		$log->logInfo("response sign=".$sign);
		$log->logInfo("response plain=".$plain);
		$checked = SignUtil::verify($plain, $sign);
		if (!$checked) {
			$log->logInfo("平台响应数据验签失败:plain=".$plain.";sign=".$sign);

			die("平台响应数据验签失败:plain=".$plain.";sign=".$sign);

		}
		//验签成功后解析响应字数据串
		$datas  = split("\|", $meta);
		$fields = split(",", $patt);
		$log->logInfo("data count= ".count($datas));
		$log->logInfo("fields count= ".count($fields));
		if (count($fields) != count($datas)) {
			$log->logInfo("待解析数据格式不正确，该功能应该包括".$patt."字段值");
			die("待解析数据格式不正确，该功能应该包括".$patt."字段值");
		}
		for ($i = 0; $i < count($datas); $i++) {
			//			if($fields[$i]=="retMsg"){
			//				$map->put($fields[$i],base64_decode($datas[$i]));
			//			}else{
			$map->put($fields[$i], $datas[$i]);
			//			}
		}
		//		$log->logInfo("response data:" . $map->toString());
		return $map;
	}
	/**
	 * V4.0解析平台响应数据
	 * @param $meta	待解析字符串
	 * @param $patt	各字段对应的字段值
	 * @return 返回解析结果,数据类型:HashMap
	 */
	public static function getDataByMetaForV4($meta, $patt) {
		$log = new Logger();
		$log->logInfo("plat response mer data:".$meta);
		$log->logInfo("interface fields:".$patt);
		$map = new HashMap();
		if (StringUtil::isNull($meta)) {
			$log->logInfo("解析失败:待解析的数据格式错误!");
			die("解析失败:待解析的数据格式错误!");
		}
		//对请响应数据进行验签
		$plain = self::getPlainByLastAnd($meta);
		$sign  = self::getSignByLastAnd($meta);
		$log->logInfo("response sign=".$plain);
		$map   = StringUtil::getCompartKeyAndValBySplit($plain, "&");
		$plain = StringUtil::getPlainSortAndByAnd($map);
		$log->logInfo("response sign=".$sign);
		$log->logInfo("response plain=".$plain);
		$plain   = iconv("UTF-8", "GBK", $plain);
		$checked = SignUtil::verify($plain, $sign);
		$plain   = iconv("GBK", "UTF-8", $plain);
		if (!$checked) {
			$log->logInfo("平台响应数据验签失败:plain=".$plain.";sign=".$sign);

			die("平台响应数据验签失败:plain=".$plain.";sign=".$sign);

		}
		$map->put("sign", $sign);
		//验签成功后解析响应字数据串
		return $map;
	}
	/**
	 *
	 * @param unknown_type $html
	 * @param unknown_type $patt
	 * @return
	 */
	public static function getDataByHtml($html, $patt) {
		if (StringUtil::isNull($html)) {
			die("解析失败:待解析的HTML为空!");
		}
		//解析HTML,获取META标签的content属性
		$content = self::getMetaByHtml($html);
		//解析CONTENT字段并进行签名验签
		$map = self::getDataByMeta($content, $patt);
		return $map;
	}
	/**
	 *
	 * @param unknown_type $html
	 * @param unknown_type $patt
	 * @return
	 */
	public static function getDataByHtmlForV4($html, $patt) {
		if (StringUtil::isNull($html)) {
			die("解析失败:待解析的HTML为空!");
		}
		//解析HTML,获取META标签的content属性
		$content = self::getMetaByHtml($html);
		//解析CONTENT字段并进行签名验签
		$map = self::getDataByMetaForV4($content, $patt);
		return $map;
	}
	/**
	 * 从HTML中获取Name=MobilePayPlatform的Meta标签Content属性值
	 * @param $html	待解析的HTML文档
	 */
	public static function getMetaByHtml($html) {
		//去除HTML前后空格
		$html = StringUtil::trim($html);
		//待解析字符串为空则返回空串
		if (StringUtil::isNull($html)) {
			die("获取平台响应数据失败:请求解析HTML为空!");
		}
		//去除HTML各标签中间字符
		$html = eregi_replace(">[^<>]+<", "><", $html);
		$html = stristr($html, "<META NAME=\"MobilePayPlatform\"");
		$html = stristr($html, "content=");
		$html = stristr($html, "\"");
		$html = substr($html, strpos($html, "\"")+1);
		$html = substr($html, 0, strpos($html, "\""));
		return $html;
	}
	/**
	 * V4.0从平台响应字符串中获取签名明文串
	 * @param $content
	 */
	public static function getPlainByLastAnd($content) {
		return substr($content, 0, strrpos($content, "&"));
	}

	/**
	 * V4.0从平台响应字符串中获取密文串
	 * @param $content
	 */
	public static function getSignByLastAnd($content) {
		return substr($content, strrpos($content, "&")+6);
	}
	/**
	 * 从平台响应字符串中获取签名明文串
	 * @param $content
	 */
	public static function getPlain($content) {
		return substr($content, 0, strrpos($content, "|"));
	}

	/**
	 * 从平台响应字符串中获取密文串
	 * @param $content
	 */
	public static function getSign($content) {
		return substr($content, strrpos($content, "|")+1);
	}

	/**
	 * 获取商户结果通知平台请求商户数据
	 * @param $map 请求数据
	 * @return	HashMap
	 */
	public static function getNotifyReqData($map) {
		$log = new Logger();
		if ($map == null || $map->size() == 0) {
			die("获取通知数据失败:待解析的数据对象为空!");
		}
		$plain = self::getNotifyPlain($map);
		$log->logInfo("getNotifyReqData plain=".$plain);
		$sign = $map->get("sign");
		$log->logInfo("getNotifyReqData sign=".$sign);
		//进行请求数据验签
		$checked = SignUtil::verify($plain, $sign);
		if (!$checked) {
			// 			die("支付结果通知平台请求数据验签失败!");
			throw new Exception("支付结果通知平台请求数据验签失败!");
		}
		return $map;
	}

	/**
	 * 获取商户结果通知平台请求数据签名明文串
	 * @param $map	请求数据
	 */
	private static function getNotifyPlain($map) {
		$data     = new HashMap();
		$merId    = StringUtil::trim($map->get("merId"));
		$goodsId  = StringUtil::trim($map->get("goodsId"));
		$orderId  = StringUtil::trim($map->get("orderId"));
		$merDate  = StringUtil::trim($map->get("merDate"));
		$payDate  = StringUtil::trim($map->get("payDate"));
		$amount   = StringUtil::trim($map->get("amount"));
		$amtType  = StringUtil::trim($map->get("amtType"));
		$bankType = StringUtil::trim($map->get("bankType"));
		$data->put("merId", $merId);
		$data->put("goodsId", $goodsId);
		$data->put("orderId", $orderId);
		$data->put("merDate", $merDate);
		$data->put("payDate", $payDate);
		$data->put("amount", $amount);
		$data->put("amtType", $amtType);
		$data->put("bankType", $bankType);
		if (!is_null($map->get("mobileId"))) {
			$data->put("mobileId", StringUtil::trim($map->get("mobileId")));
		}
		$transType  = StringUtil::trim($map->get("transType"));
		$settleDate = StringUtil::trim($map->get("settleDate"));
		$data->put("transType", $transType);
		$data->put("settleDate", $settleDate);
		if (!is_null($map->get("merPriv"))) {
			$data->put("merPriv", StringUtil::trim($map->get("merPriv")));
		}
		$retCode = StringUtil::trim($map->get("retCode"));
		$version = StringUtil::trim($map->get("version"));
		$data->put("retCode", $retCode);
		$data->put("version", $version);
		return StringUtil::getPlainByAnd($data);
	}
	/**
	 * V4.0获取商户结果通知平台请求商户数据
	 * @param $map 请求数据
	 * @return	HashMap
	 */
	public static function getNotifyRequestData($map) {
		$log = new Logger();
		if ($map == null || $map->size() == 0) {
			die("获取通知数据失败:待解析的数据对象为空!");
		}
		$plain = self::getNotifyRequestPlain($map);
		$plain = iconv("UTF-8", "GBK", $plain);
		$log->logInfo("getNotifyRequestData plain=[".$plain."]");
		$sign = StringUtil::trim($map->get("sign"));
		$log->logInfo("getNotifyRequestData sign=[".$sign."]");
		//进行请求数据验签
		$checked = SignUtil::verify($plain, $sign);
		if (!$checked) {
			die("支付结果通知平台请求数据验签失败!");
			throw new Exception("支付结果通知平台请求数据验签失败!");
		}
		return $map;
	}
	/**
	 *V4.0 获取商户结果通知平台请求商户数据
	 * @param $map 请求数据
	 * @return	HashMap
	 */
	public static function getSplitRequestNotifyReqData($map) {
		$log = new Logger();
		if ($map == null || $map->size() == 0) {
			die("获取通知数据失败:待解析的数据对象为空!");
		}
		$plain = self::getSplitRequestNotifyPlain($map);
		$plain = iconv("UTF-8", "GBK", $plain);
		$log->logInfo("getSplitRequestNotifyReqData plain=".$plain);
		$sign = $map->get("sign");
		$log->logInfo("getSplitRequestNotifyReqData sign=".$sign);
		//进行请求数据验签
		$checked = SignUtil::verify($plain, $sign);
		if (!$checked) {
			die("支付结果通知平台请求数据验签失败!");
		}
		return $map;
	}
	/**
	 *V4.0 获取商户结果通知平台请求商户数据
	 * @param $map 请求数据
	 * @return	HashMap
	 */
	public static function getSplitMerRefundNotifyReqData($map) {
		$log = new Logger();
		if ($map == null || $map->size() == 0) {
			die("获取通知数据失败:待解析的数据对象为空!");
		}
		$plain = self::getSplitMerRefundNotifyPlain($map);
		$plain = iconv("UTF-8", "GBK", $plain);
		$log->logInfo("getSplitMerRefundNotifyReqData plain=[".$plain."]");
		$sign = $map->get("sign");
		$log->logInfo("getSplitMerRefundNotifyReqData sign=".$sign);
		//进行请求数据验签
		$checked = SignUtil::verify($plain, $sign);
		if (!$checked) {
			die("支付结果通知平台请求数据验签失败!");
		}
		return $map;
	}
	/**
	 * V4.0获取商户结果通知平台请求数据签名明文串
	 * @param $map	请求数据
	 */
	private static function getNotifyRequestPlain($map) {
		$data = new HashMap();
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				//if($key != "sign_type" && $key != "sign"){
				if ($key != "sign") {
					$data->put($key, StringUtil::trim($map->get($key)));
				}
			}
		}
		return StringUtil::getPlainSortAndByAnd($data);
	}

	/**
	 * V4.0获取商户分账请求结果通知平台请求数据签名明文串
	 * @param $map	请求数据
	 */
	private static function getSplitRequestNotifyPlain($map) {
		$data       = new HashMap();
		$service    = StringUtil::trim($map->get("service"));
		$charset    = StringUtil::trim($map->get("charset"));
		$mer_id     = StringUtil::trim($map->get("mer_id"));
		$sign_type  = StringUtil::trim($map->get("sign_type"));
		$order_id   = StringUtil::trim($map->get("order_id"));
		$mer_date   = StringUtil::trim($map->get("mer_date"));
		$is_success = StringUtil::trim($map->get("is_success"));
		$version    = StringUtil::trim($map->get("version"));
		$data->put("service", $service);
		$data->put("charset", $charset);
		$data->put("mer_id", $mer_id);
		$data->put("sign_type", $sign_type);
		$data->put("order_id", $order_id);
		$data->put("mer_date", $mer_date);
		$data->put("is_success", $is_success);
		$data->put("version", $version);
		if (!is_null($map->get("error_code"))) {
			$data->put("error_code", StringUtil::trim($map->get("error_code")));
		}
		return StringUtil::getPlainSortAndByAnd($data);
	}

	/**
	 * V4.0获取商户分账退费结果通知平台请求数据签名明文串
	 * @param $map	请求数据
	 */
	private static function getSplitMerRefundNotifyPlain($map) {
		$data           = new HashMap();
		$service        = StringUtil::trim($map->get("service"));
		$charset        = StringUtil::trim($map->get("charset"));
		$mer_id         = StringUtil::trim($map->get("mer_id"));
		$sign_type      = StringUtil::trim($map->get("sign_type"));
		$order_id       = StringUtil::trim($map->get("order_id"));
		$mer_date       = StringUtil::trim($map->get("mer_date"));
		$refund_no      = StringUtil::trim($map->get("refund_no"));
		$sub_order_id   = StringUtil::trim($map->get("sub_order_id"));
		$sub_refund_amt = StringUtil::trim($map->get("sub_refund_amt"));
		$refund_amount  = StringUtil::trim($map->get("refund_amount"));
		$org_amount     = StringUtil::trim($map->get("org_amount"));
		$refund_amt     = StringUtil::trim($map->get("refund_amt"));
		$is_success     = StringUtil::trim($map->get("is_success"));
		$sub_mer_id     = StringUtil::trim($map->get("sub_mer_id"));
		$version        = StringUtil::trim($map->get("version"));
		$data->put("service", $service);
		$data->put("charset", $charset);
		$data->put("mer_id", $mer_id);
		$data->put("sign_type", $sign_type);
		$data->put("order_id", $order_id);
		$data->put("sub_mer_id", $sub_mer_id);
		$data->put("refund_amount", $refund_amount);
		$data->put("mer_date", $mer_date);
		$data->put("refund_no", $refund_no);
		$data->put("refund_amt", $refund_amt);
		$data->put("is_success", $is_success);
		$data->put("sub_refund_amt", $sub_refund_amt);
		$data->put("org_amount", $org_amount);
		$data->put("sub_order_id", $sub_order_id);
		$data->put("version", $version);
		if (!is_null($map->get("error_code"))) {
			$data->put("error_code", StringUtil::trim($map->get("error_code")));
		}
		return StringUtil::getPlainSortAndByAnd($data);
	}
}

?>
