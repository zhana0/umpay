<?php
namespace api;
require_once 'config.php';

// 	require_once 'mapping_regex.php';
// 	$mer_pk = require('config.php');
// 	include 'config.php';
//---------------------------------------------------------------
//访问地址配置管理
//---------------------------------------------------------------
//商户向平台下订单(统一支付)
define("webreqpay_url", "/ms/reqPayWeb.ms");
//商户向平台下订单(网银直连)
define("webDirectWyPay_url", "/ms/directWebBank.ms");
//商户向平台下订单(后台直连)
define("directpay_url", "/ms/directOrder.ms");
//查询交易记录
define("querytrans_url", "/ms/queryOrderInfo.ms");
//获取交易数据对帐文件
define("transbill_url", "/ms/downLoadBill.ms");
//获取清算数据对帐文件
define("settlebill_url", "/ms/downLoadSettle.ms");
//商户撤销服务
define("cancel_url", "/ms/transCancel.ms");
//商户退费服务
define("rfund_url", "/ms/transRefund.ms");
//微支付下单
define("micropayreqpay_url", "/micropayReq.do");
//微支付撤销
define("umpay_urls", "webReqPay=/ms/reqPayWeb.ms;directPay=/ms/directOrder.ms;"
	."reqWY=/ms/directWebBank.ms;queryTrans=/ms/queryOrderInfo.ms;"
	."refund=/ms/transRefund.ms;cancel=/ms/transCancel.ms;"
	."settleBill=/ms/downLoadSettle.ms;transBill=/ms/downLoadBill.ms;"
	."microPayReq=/micropayReq.do;microPayCancel=/ms/transCancel.ms;"
	."billFileHf=/pay/billFileHf.do;");

//4.0交易提交地址
define("umpay_url", "/pay/payservice.do");

//--------------------------------------------------------------
//模块功能码
//--------------------------------------------------------------
define("funcode_webReqPay", "webReqPay");
define("funcode_webDirectWyPay", "reqWY");
define("funcode_directPay", "directPay");
define("funcode_queryTrans", "queryTrans");
define("funcode_merCancel", "cancel");
define("funcode_merRefund", "refund");
define("funcode_transBill", "transBill");
define("funcode_settleBill", "settleBill");
define("funcode_microPayReq", "microPayReq");
define("funcode_microPayCancel", "microPayCancel");
define("funcode_billFileHf", "billFileHf");
//---------------------------------------------------------
//V4.0商户请求平台数据字段
//---------------------------------------------------------
//分账下单数据字段
define("pay_req_split", "service=32;charset=16;mer_id=8;sign_type=8;ret_url=128;notify_url=128;version=3;order_id=32;mer_date=8;amount=13;amt_type=8;");

define("pay_req_split1", "res_format=16;goods_id=8;goods_inf=64;media_id=32;media_type=16;pay_type=16;gate_id=16;mer_priv=128;user_ip=16;expand=128;expire_time=8;split_data=256;split_type=9");

//分账请求数据字段
//define ( "split_req", "service=32;charset=16;mer_id=8;sign_type=8;version=3;order_id=32;mer_date=8;amount=13;amt_type=8;split_type=2;split_data=256" );

//define ( "split_req1", "notify_url=128;res_format=128" );

//分账退费数据字段
define("split_refund_req", "service=32;charset=16;mer_id=8;sign_type=8;version=3;refund_no=16;order_id=32;mer_date=8;refund_amount=13;org_amount=13;sub_mer_id=8;sub_order_id=32");

define("split_refund_req1", "refund_desc=128;notify_url=128;res_format=128");

//信用卡直连数据字段
define("credit_direct_pay", "service=32;charset=16;mer_id=8;sign_type=8;version=3;order_id=32;mer_date=8;amount=13;amt_type=8;pay_type=16;card_id=32;valid_date=8;cvv2=32");

define("credit_direct_pay1", "pass_wd=32;identity_type=32;identity_code=32;card_holder=32;mer_priv=128;expand=128;expire_time=8;split_data=256;split_type=9;goods_id=8;goods_inf=64;media_id=32;media_type=16;notify_url=128;res_format=128");

//借记卡直连数据字段
define("debit_direct_pay", "service=32;charset=16;mer_id=8;sign_type=8;version=3;order_id=32;mer_date=8;amount=13;amt_type=8;pay_type=16;card_id=32");

define("debit_direct_pay1", "pass_wd=32;mer_priv=128;expand=128;expire_time=8;split_data=256;split_type=9;goods_id=8;goods_inf=64;media_id=32;media_type=16;notify_url=128;res_format=128;identity_type=32;identity_code=32;card_holder=32");

//无线类支付数据字段
define("pay_req", "service=32;charset=16;mer_id=8;sign_type=8;notify_url=128;version=3;order_id=32;mer_date=8;amount=13;amt_type=8");

define("pay_req1", "goods_id=8;goods_inf=64;ret_url=128;media_id=32;media_type=16;pay_type=16;gate_id=16;mer_priv=128;user_ip=16;expand=128;expire_time=8;split_category=1;split_type=2;split_data=256");

//订单查询请求数据字段
define("query_order", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;mer_date=8");

define("query_order1", "amount=13;trade_no=16;goods_id=8;media_id=32;media_type=16;res_format=16");

//订单查询（支持12月）
define("mer_order_info_query", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;mer_date=8;");

define("mer_order_info_query1", "res_format=16;order_type=1");

//退费订单查询（支持12月）
define("mer_refund_query", "service=32;sign_type=8;charset=16;mer_id=8;version=3;refund_no=16");

define("mer_refund_query1", "res_format=16;");

//分账订单查询
define("query_split_order", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;mer_date=8");

define("query_split_order1", "res_format=16");
//分账指令
define("split_req", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;mer_date=8");

define("split_req1", "res_format=16;split_cmd=256");

//商户撤销请求数据字段
define("mer_cancel", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;amount=13;mer_date=8");

define("mer_cancel1", "res_format=16");
//商户退费请求数据字段
define("mer_refund", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;org_amount=13;refund_no=16;mer_date=8");

define("mer_refund1", "res_format=16;notify_url=128;refund_amount=13");

//商户退费请求数据字段
define("pay_guide", "service=32;sign_type=8;charset=16;token=32;mer_id=8;version=3");

define("pay_guide1", "res_format=16");
//商户清算队长请求数据字段
define("download_settle_file", "service=32;sign_type=8;mer_id=8;version=3;settle_date=8");

define("download_settle_file1", "res_format=16");
//信用卡快捷确认支付，必填字段，非必填字段
define("pay_confirm", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;verify_code=4;pay_category=2;card_id=32;valid_date=8;cvv2=32");

define("pay_confirm1", "media_id=32;media_type=16;pass_wd=6;res_format=16;identity_type=32;identity_code=32;card_holder=32");

//获取短信验证码
define("req_sms_verifycode", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;media_id=32;media_type=16");

define("req_sms_verifycode1", "res_format=16");
//付款API-下单
define("transfer_direct_req", "service=32;charset=16;mer_id=8;sign_type=8;notify_url=128;version=3;order_id=32;mer_date=8;amount=13;recv_account_type=2;recv_bank_acc_pro=1;recv_account=30;recv_user_name=30;recv_gate_id=16;purpose=20;prov_name=20;city_name=20;bank_brhname=60");

define("transfer_direct_req1", "res_format=16;media_id=32;media_type=16;identity_type=2;identity_code=32;identity_holder=30");

//付款API-订单查询
define("transfer_query", "service=32;sign_type=8;charset=16;order_id=32;mer_id=8;version=3;mer_date=8");

define("transfer_query1", "res_format=16");
//商户现金账户余额查询
define("query_account_balance", "service=32;sign_type=8;charset=16;mer_id=8;version=3");

define("query_account_balance1", "res_format=16");
//一键快捷-前台支付请求
define("pay_req_shortcut_front", "service=32;charset=16;mer_id=8;sign_type=8;ret_url=128;notify_url=128;version=3;order_id=32;mer_date=8;amount=13;amt_type=8");

define("pay_req_shortcut_front1", "res_format=16;goods_id=8;goods_inf=64;media_id=32;media_type=16;pay_type=16;gate_id=16;mer_priv=128;user_ip=16;expand=128;expire_time=8;split_category=1;split_type=2;split_data=256");

//一键快捷-API下单
define("pay_req_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;notify_url=128;version=3;order_id=32;mer_date=8;amount=13;amt_type=8");

define("pay_req_shortcut1", "goods_id=8;goods_inf=64;mer_priv=128;expand=128;expire_time=8;split_category=1;split_type=2;split_data=256");

//一键快捷-获取短信验证码
define("req_smsverify_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;media_id=32;media_type=16");

define("req_smsverify_shortcut1", "pay_type=16;card_id=32;valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32;mer_cust_id=32;usr_busi_agreement_id=64;usr_pay_agreement_id=64");

//一键快捷-确认支付
define("pay_confirm_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;media_id=32;media_type=16");

define("pay_confirm_shortcut1", "pay_type=16;card_id=32;valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32;mer_cust_id=32;usr_busi_agreement_id=64;usr_pay_agreement_id=64");

//一键快捷-首次支付确认支付
define("first_pay_confirm_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;media_id=32;media_type=16;card_id=32");

define("first_pay_confirm_shortcut1", "verify_code=8;valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32;mer_cust_id=32");

//一键快捷-协议支付确认支付
define("agreement_pay_confirm_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;trade_no=16;usr_pay_agreement_id=64");

define("agreement_pay_confirm_shortcut1", "verify_code=8;birthday=8;valid_date=8;cvv2=32;mer_cust_id=32;usr_busi_agreement_id=64");

//一键快捷-API绑定协议申请
define("req_bind_verify_shortcut", "service=32;mer_id=8;sign_type=8;version=3;media_id=32;media_type=16;card_id=32");

define("req_bind_verify_shortcut1", "valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32");

//一键快捷-API绑定协议确认
define("req_bind_confirm_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;media_id=32;media_type=16;card_id=32");

define("req_bind_confirm_shortcut1", "verify_code=8;reg_no=16;valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32;mer_cust_id=32");

//一键快捷-查询商户支持的银行列表
define("query_mer_bank_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;pay_type=16");

define("query_mer_bank_shortcut1", "res_format=16");
//一键快捷-查询商户用户已签约的银行列表
define("query_mercust_bank_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;pay_type=16;");

define("query_mercust_bank_shortcut1", "res_format=16;mer_cust_id=32;usr_busi_agreement_id=64");

//一键快捷-商户解除用户关联
define("unbind_mercust_protocol_shortcut", "service=32;charset=16;mer_id=8;sign_type=8;version=3;");

define("unbind_mercust_protocol_shortcut1", "res_format=16;mer_cust_id=32;usr_busi_agreement_id=64");

//实名认证
define("card_auth", "service=32;charset=16;mer_id=8;sign_type=8;version=3;mer_date=8;card_id=32;valid_date=8;cvv2=32;identity_type=32;identity_code=32;card_holder=32;");

define("card_auth1", "mobile_id=32;res_format=16");

//--------------------------------------------------------------
//后台直连接口平台响应数据字段
//--------------------------------------------------------------
//订单查询数据字段
define("fields_querytrans", "merId,goodsId,orderId,merDate,payDate,amount,amtType,bankType,mobileId,gateId,transType,transState,settleDate,bankCheck,merPriv,retCode,version,sign");
//商户撤销交易数据字段
define("fields_cancel", "merId,amount,retCode,retMsg,version,sign");
//商户退费交易数据字段
define("fields_refund", "merId,refundNo,amount,retCode,retMsg,version,sign");
//后台直连数据字段
define("fields_directreqpay", "merId,goodsId,orderId,merDate,retCode,retMsg,version,sign");
//微支付商户撤销交易数据字段
define("fields_micorpay_cancel", "merId,amount,retCode,retMsg,version,sign");

define("method_get", "get");
define("method_post", "post");
/**
 * 数据签名,验签处理工具类
 * @author xuchaofu
 * 2010-03-29
 */
Class SignUtil {
	/**
	 * 数据签名
	 * @param $plain	签名明文串
	 * @param $priv_key_file	商户租钥证书
	 */
	public static function sign2($plain, $merId) {
		$log    = new Logger();
		$mer_pk = require_once ('config.php');
		try {
			//用户租钥证书
			$priv_key_file = privatekey;
			//如果商户号不为空，则获取商户私钥地址配置信息
			if (!is_null($merId)) {
				if (!is_null($mer_pk[$merId])) {
					$priv_key_file = $mer_pk[$merId];
				}
			}
			$log->logInfo("The private key path for：".$priv_key_file);
			if (!File_exists($priv_key_file)) {
				return FALSE;
				die("The key is not found, please check the configuration!");
			}
			$fp = fopen($priv_key_file, "rb");

			$priv_key = fread($fp, 8192);
			@fclose($fp);
			$pkeyid = openssl_get_privatekey($priv_key);

			if (!is_resource($pkeyid)) {return FALSE;}
			// compute signature
			@openssl_sign($plain, $signature, $pkeyid);
			// free the key from memory
			@openssl_free_key($pkeyid);
			$log->logInfo("Signature string for：".$signature);
			return base64_encode($signature);
		} catch (Exception $e) {
			$log->logInfo("Signature attestation failure".$e->getMessage());
		}
	}
	/**
	 * 数据签名
	 * @param $plain	签名明文串
	 * @param $priv_key_file	商户租钥证书
	 */
	public static function sign($plain) {
		$log = new Logger();
		//     	$mer_pk = require('config.php');
		try {
			//用户租钥证书
			$priv_key_file = privatekey;
			//如果商户号不为空，则获取商户私钥地址配置信息
			//     		if(!is_null($merId)){
			//     			if(!is_null($mer_pk[$merId])){
			//     				$priv_key_file = $mer_pk[$merId];
			//     			}
			//     		}
			$log->logInfo("The private key path for：".$priv_key_file);
			if (!File_exists($priv_key_file)) {
				return FALSE;
				die("The key is not found, please check the configuration!");
			}
			$fp = fopen($priv_key_file, "rb");

			$priv_key = fread($fp, 8192);
			@fclose($fp);
			$pkeyid = openssl_get_privatekey($priv_key);

			if (!is_resource($pkeyid)) {return FALSE;}
			// compute signature
			@openssl_sign($plain, $signature, $pkeyid);
			// free the key from memory
			@openssl_free_key($pkeyid);
			$log->logInfo("Signature string for：".$signature);
			return base64_encode($signature);
		} catch (Exception $e) {
			$log->logInfo("Signature attestation failure".$e->getMessage());
		}
	}
	/**
	 * 签名数据验签
	 * @param $plain 验签明文
	 * @param $signature 验签密文
	 */
	public static function verify($plain, $signature) {
		$log       = new Logger();
		$cert_file = platcert;
		if (!File_exists($cert_file)) {
			return FALSE;
			die("未找到密钥,请检查配置!");
		}
		$signature = base64_decode($signature);

		$fp   = fopen($cert_file, "r");
		$cert = fread($fp, 8192);
		fclose($fp);

		$pubkeyid = openssl_get_publickey($cert);
		if (!is_resource($pubkeyid)) {
			return FALSE;
		}
		$ok = openssl_verify($plain, $signature, $pubkeyid);
		@openssl_free_key($pubkeyid);
		$log->logInfo("verify:".$ok);
		if ($ok == 1) {//1
			return TRUE;
		} elseif ($ok == 0) {//2
			return FALSE;
		} else {//3
			return FALSE;
		}
		return FALSE;
	}
}
/**
 * V4.0数据加密,解密处理工具类
 * @author 朱锦飞
 * 2011-18-08
 */
class RSACryptUtil {
	/**
	 * 对明文进行加密
	 * @param $data 要加密的明文
	 */
	public static function encrypt($data) {
		$log       = new Logger();
		$cert_file = platcert;
		if (!File_exists($cert_file)) {
			return FALSE;
			die("未找到密钥,请检查配置!");
		}
		$fp         = fopen($cert_file, "r");
		$public_key = fread($fp, 8192);
		fclose($fp);
		$public_key = openssl_get_publickey($public_key);
		//private encrypt
		openssl_public_encrypt($data, $crypttext, $public_key);
		//加密後產生出參數$crypttext
		//public decrypt
		//openssl_public_encrypt ( $crypttext, $newsource, $public_key );
		$encryptDate = base64_encode($crypttext);
		//解密後的結果$newsource
		$log->logInfo("敏感信息加密密文:[".$encryptDate."]");
		return $encryptDate;
	}

	/**
	 * 密文解密
	 * @param $data 要解密的密文
	 * @param $data 商户号
	 */
	public function decrypt($data, $merId) {
		$log = new Logger();
		//用户租钥证书
		$mer_pk        = require ('config.php');
		$priv_key_file = privatekey;
		//如果商户号不为空，则获取商户私钥地址配置信息
		if (!is_null($merId)) {
			if (!is_null($mer_pk[$merId])) {
				$priv_key_file = $mer_pk[$merId];
			}
		}
		$log->logInfo("The private key path for：".$priv_key_file);
		if (!File_exists($priv_key_file)) {
			return FALSE;
			die("The key is not found, please check the configuration!");
		}
		$fp          = fopen($priv_key_file, "r");
		$private_key = fread($fp, 8192);
		fclose($fp);
		$private_key = openssl_get_privatekey($private_key);
		openssl_private_decrypt(base64_decode($data), $decrypted, $private_key);
		$decryptDate = iconv("GBK", "UTF-8", $decrypted);
		$log->logInfo("敏感信息解密后明文:[".$decryptDate."]");
		return $decryptDate;
	}

}
/**
 * 模拟实现HashMap,相当于Java的LinkedHashMap
 * @author xuchaofu
 *	2010-03-29
 */
Class HashMap {
	var $H_table;

	/*
	 * HashMap构造函数
	 */
	public function __construct() {
		$this->H_table = array();
	}

	/*
	 *向HashMap中添加一个键值对
	 *@param $key	插入的键
	 *@param $value	插入的值
	 */
	public function put($key, $value) {
		if (!array_key_exists($key, $this->H_table)) {
			$this->H_table[$key] = $value;
			return null;
		} else {
			$tempValue           = $this->H_table[$key];
			$this->H_table[$key] = $value;
			return $tempValue;
		}
	}

	/*
	 * 根据key获取对应的value
	 * @param $key
	 */
	public function get($key) {
		if (array_key_exists($key, $this->H_table)) {
			return $this->H_table[$key];
		} else {

			return null;
		}
	}

	/*
	 *移除HashMap中所有键值对
	 */
	/*
	 *删除指定key的键值对
	 *@param $key	要移除键值对的key
	 */
	public function remove($key) {
		$temp_table = array();
		if (array_key_exists($key, $this->H_table)) {
			$tempValue = $this->H_table[$key];
			while ($curValue = current($this->H_table)) {
				if (!(key($this->H_table) == $key)) {
					$temp_table[key($this->H_table)] = $curValue;
				}

				next($this->H_table);
			}
			$this->H_table = null;
			$this->H_table = $temp_table;
			return $tempValue;
		} else {

			return null;
		}
	}

	/**
	 * 获取HashMap的所有键值
	 * @return 返回HashMap中key的集合,以数组形式返回
	 */
	public function keys() {
		return array_keys($this->H_table);
	}
	/**
	 * 获取HashMap的所有value值
	 */
	public function values() {
		return array_values($this->H_table);
	}

	/**
	 * 将一个HashMap的值全部put到当前HashMap中
	 * @param $map
	 */
	public function putAll($map) {
		if (!$map->isEmpty() && $map->size() > 0) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				$this->put($key, $map->get($key));
			}
		}
	}

	/**
	 * 移除HashMap中所有元素
	 */
	public function removeAll() {
		$this->H_table = null;
		$this->H_table = array();
	}

	/*
	 *HashMap中是否包含指定的值
	 *@param $value
	 */
	public function containsValue($value) {
		while ($curValue = current($this->H_table)) {
			if ($curValue == $value) {
				return true;
			}
			next($this->H_table);
		}
		return false;
	}

	/*
	 *HashMap中是否包含指定的键key
	 *@param $key
	 */
	public function containsKey($key) {
		if (array_key_exists($key, $this->H_table)) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 *获取HashMap中元素个数
	 */
	public function size() {
		return count($this->H_table);
	}

	/*
	 *判断HashMap是否为空
	 */
	public function isEmpty() {
		return (count($this->H_table) == 0);
	}

	/**
	 *
	 */
	public function toString() {
		print_r($this->H_table);
	}
}

/**
 * 字符串处理工具类
 * @author xuchaofu
 *	2010-03-29
 */
Class StringUtil {

	/**
	 * 去除字符串前后空格,如果字符串为null则返回空串""
	 * @param $str
	 */
	public static function trim($str) {
		if ($str == null) {
			return "";
		} else {
			return trim($str);
		}
	}

	/**
	 * 判断字符串是否为null或为空串
	 * @param $str
	 */
	public static function isNull($str) {
		$str = self::trim($str);
		if ($str == "") {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 判断字符串是否不为空或空串
	 * @param unknown_type $str
	 */
	public static function isNotNull($str) {
		return !self::isNull($str);
	}

	/**
	 * 使用|符号组织签名明文串，如：9996|100|3.0
	 * @param $map
	 */
	public static function getPlainByLine($map) {
		$plain = "";
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				$plain = $plain.$map->get($key)."|";
			}
			$plain = substr($plain, 0, strlen($plain)-1);
			return $plain;
		} else {
			die("使用|组织签名明文串失败:传入参数为空!");
			return null;
		}
		return $plain;
	}

	/**
	 * getPlainByAnd方法 使用&符号组织签名明文串，如：merId=9996&goodsId=100&version=3.0
	 * @param HashMap $map
	 */
	public static function getPlainByAnd($map) {
		$plain = "";
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				$plain = $plain.$key."=".trim($map->get($key))."&";
			}
			$plain = substr($plain, 0, strlen($plain)-1);
			return $plain;
		} else {
			die("使用&组织签名明文串失败:传入参数为空!");
			return null;
		}
		return $plain;
	}
	/**
	 * getPlainSortAndByAnd方法 使用&符号组织签名明文串排序a-z，如：merId=9996&goodsId=100&version=3.0
	 * @param HashMap $map
	 */
	public static function getPlainSortAndByAnd($map) {
		$log      = new Logger();
		$plain    = "";
		$arg      = "";
		$paramter = array();
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				// $log->logInfo (" ssssssgetRequestData plain111122333=" . $keys );
				//如果是sign_type 不许要参与RAS签名
				if ("sign_type" != $key) {
					$plain = $plain.$key."=".trim($map->get($key))."|";
					//$paramter = explode ( "&", $plain );
					$paramter[$key."=".trim($map->get($key))] = $key."=".trim($map->get($key));
				}
			}
			$plain = substr($plain, 0, strlen($plain)-1);
			// 			$log->logInfo (" ssssssgetRequestData plain111122=" . $plain );
			//$paramter = explode ( "|", $plain );
			$sort_array = StringUtil::arg_sort($paramter);//得到从字母a到z排序后的加密参数数组

			while (list($key, $val) = each($sort_array)) {
				$arg .= $val."&";
				//$log->logInfo (" ssssssgetRequestData plain11=" . $arg );
			}
			$arg = substr($arg, 0, count($arg)-2);//去掉最后一个&字符
			//die ( "使用&组织签名明文串失败:传入参数为空!".$arg."|".plain );
			return $arg;
		} else {
			die("Use & organize signature plaintext string failure: incoming parameters is empty!");
			return null;
		}
		//$log->logInfo (" ssssssgetRequestData plain115=" . $arg );
		return $arg;
	}
	/**
	 * V4.0排序方法
	 * arg_sort方法 对数组排序排序a-z
	 * @param $array $map排序前的数组
	 * return 排序后的数组
	 */
	public static function arg_sort($array) {
		asort($array);
		return $array;
	}
	/**
	 * 获取请求参数字符串,并对参数值进行URL编码，如：merId=9996&goodsId=100&version=3.0
	 * @param $map
	 */
	public static function getParameter($map) {
		$param = "";
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				$param = $param.$key."=".urlencode($map->get($key))."&";
			}
			$param = substr($param, 0, strlen($param)-1);
			return $param;
		} else {
			die("获取请求参数字符串失败:传入参数为空!");
		}
		return $param;
	}
	/**
	 * V4.0获取请求参数字符串并进行排序,并对参数值进行URL编码，如：amount=100&goodsId=100&merId=9996&version=3.0
	 * @param $map
	 */
	public static function getSortParameter($map) {
		$param    = "";
		$arg      = "";
		$paramter = array();
		if ((!$map->isEmpty()) && ($map->size() > 0)) {
			$keys = $map->keys();
			foreach ($keys as $key) {
				$param                                               = $param.$key."=".urlencode(trim($map->get($key)))."&";
				$paramter[$key."=".urlencode(trim($map->get($key)))] = $key."=".urlencode(trim($map->get($key)));
			}
			$param = substr($param, 0, strlen($param)-1);
			//$paramter = explode ( "&", $param );
			$sort_array = StringUtil::arg_sort($paramter);//得到从字母a到z排序后的加密参数数组
			$log        = new Logger();
			while (list($key, $val) = each($sort_array)) {
				$arg .= $val."&";
			}
			$arg = substr($arg, 0, count($arg)-2);//去掉最后一个&字符
			return $arg;
		} else {
			die("获取请求参数字符串失败:传入参数为空!");
		}
		return $arg;
	}
	/**
	 * 解析以指定符号分隔的键值串,以;
	分隔为例,格式:key1=value1;
	key2=value2;
	keyn=valuen;

	 * 例:webReqPay=/pay/payGatePrePay.do;
	directReqPay=/payGateDirectPay.do;

	 * @param $str	待解析的字符串
	 * @param $patt	字符串分隔符
	 */
	public static function getCompartKeyAndVal($str) {
		$map    = new HashMap();
		$fields = array();
		$values = array();
		$fields = explode(";", $str);

		if (count($fields) > 0) {
			foreach ($fields as $field) {
				$values = explode("=", $field);
				if (count($values) == 2) {
					$map->put($values[0], $values[1]);
				}
			}
		}
		return $map;
	}

	/**
	 * 解析以指定符号分隔的键值串,以;
	分隔为例,格式:key1=value1;
	key2=value2;
	keyn=valuen;

	 * 例:webReqPay=/pay/payGatePrePay.do;
	directReqPay=/payGateDirectPay.do;

	 * @param $str	待解析的字符串
	 * @param $str1	制定的分割符
	 * @param $patt	字符串分隔符
	 */
	public static function getCompartKeyAndValBySplit($str, $str1) {
		$log    = new Logger();
		$map    = new HashMap();
		$fields = array();
		$values = array();
		$fields = explode($str1, $str);
		if (count($fields) > 0) {
			foreach ($fields as $field) {
				$values = split("=", $field);
				if (count($values) == 2) {
					$map->put($values[0], $values[1]);
				} elseif (count($values) > 2) {
					$map->put($values[0], substr($field, strlen($values[0])+1));
				}
			}
		}
		return $map;
	}
}

/**
 * 日期处理工具类
 * @author xuchaofu
 *	2010-04-01
 */
Class DateUtil {
	public static function checkData($date) {
		if (empty($date)) {
			return false;
		}
		return preg_match("|^\d{8}$|", $date);
	}
}

/**
 * API日志处理类
 * @author xuchaofu
 * 2010-04-01
 *
 */
Class Logger {
	public static function logInfo($msg) {
		$filePath = logpath.date("Ymd");
		//异步通知时，记录日志不存在$_SERVER['HTTP_REFERER']，手动设置默认值（zhana0添加）
		$_SERVER['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
		$msg                     = date("[Y-m-d H:i:s]")."-[".$_SERVER['HTTP_REFERER']."]-[data] :".$msg."\n";
		error_log($msg, 3, $filePath);
		if (log_echo) {
			echo $msg;
		}
		//		echo "\n".$_SERVER['HTTP_ACCEPT_CHARSET'];
	}
}

Class CheckReqDataAndEncrypt {
	public static $keysarray      = array();
	public static $regexkeysarray = array();
	public static function doCheck($map) {
		$log = new Logger();
		// 功能码不能为空
		$service = $map->get("service");
		;

		if (empty($service)) {
			die("The parameters of the request the service cannot be empty");
		}
		return;
		// 找到这个服务需要校验哪些字段
		if (count(CheckReqDataAndEncrypt::$keysarray) <= 0) {
			$log->logInfo("loading mapping_keys.ini");
			CheckReqDataAndEncrypt::$keysarray = parse_ini_file("mapping_keys.ini");
		}
		$keys = CheckReqDataAndEncrypt::$keysarray["Service.".$service];
		if (empty($keys)) {
			$log->logInfo("Not configure corresponding ".$service." interface parameter information,Please in mapping_keys.ini configuration file");
			return;
		}
		// 对每个key进行正则表达式校验
		$chkKeys = array();
		$chkKeys = explode(",", $keys);
		if (count($chkKeys) > 0) {
			foreach ($chkKeys as $key) {
				CheckReqDataAndEncrypt::doCheckParams($key, $map);
			}
		}
	}
	public static function doEncrypt($map) {
		$log = new Logger();
		// 找到这个服务需要校验哪些字段
		// 		if(count(CheckReqDataAndEncrypt::$keysarray)<=0){
		// 			$log->logInfo ("loading mapping_keys.ini");
		// 			CheckReqDataAndEncrypt::$keysarray=parse_ini_file("mapping_keys.ini");
		// 		}
		// 		$keys = CheckReqDataAndEncrypt::$keysarray["Encrypt.Paramters"];
		// 		if (empty($keys)) {
		// // 			die("Not configured to RSA encrypt sensitive fields");
		// 			$log->logInfo ("Not configured to RSA encrypt sensitive fields");
		// 			return $map;
		// 		}
		// 对每个key进行正则表达式校验
		$keys    = "card_id,valid_date,cvv2,pass_wd,identity_code,card_holder,recv_account,recv_user_name,identity_holder,identityCode,cardHolder,mer_cust_name,account_name,bank_account,endDate";
		$chkKeys = array();
		$chkKeys = explode(",", $keys);
		if (count($chkKeys) > 0) {
			foreach ($chkKeys as $key) {
				$value = $map->get($key);
				if (empty($value)) {
					continue;
				}
				$log->logInfo("The parameters of the request ".$key." RSA encryption");
				$value = iconv("UTF-8", "GBK", $value);
				$value = RSACryptUtil::encrypt($value);
				$map->put($key, $value);
			}
		}
		return $map;
	}
	/**
	 * delegater
	 *
	 * @param key
	 * @param dc
	 * @throws Exception
	 */
	protected static function doCheckParams($key, $map) {
		if (empty($key)) {
			return;
		}
		if (CheckReqDataAndEncrypt::isOptional($key)) {
			// 			$log = new Logger ();
			// 			$log->logInfo ("The parameters of the request ". $key. "");
			CheckReqDataAndEncrypt::check(CheckReqDataAndEncrypt::removBrackets($key), $map, false);
		} else {
			CheckReqDataAndEncrypt::check($key, $map, true);
		}
	}
	/**
	 * 去除中括号
	 *
	 * @param key
	 *            待校验的Key
	 * @return 去除中括号的字符串
	 */
	protected static function removBrackets($key) {
		// 		$log = new Logger ();
		// 		$log->logInfo (substr($key,1,strlen(StringUtil::trim($key))-2));
		return substr($key, 1, strlen(StringUtil::trim($key))-2);
	}

	/**
	 * 是否是必须的字段
	 *
	 * @param key
	 *            待校验的Key
	 * @return 必须字段返回<tt>true</tt>, 否则返回<tt>false</tt>
	 */
	protected static function isOptional($key) {
		return CheckReqDataAndEncrypt::startsWith($key, "[") && CheckReqDataAndEncrypt::endsWith($key, "]");
	}

	function startsWith($haystack, $needle) {
		return $needle == "" || strpos($haystack, $needle) == 0;
	}
	function endsWith($haystack, $needle) {
		return $needle == "" || substr($haystack, -strlen($needle)) == $needle;
	}

	/**
	 * 真正的校验逻辑，通过配置的正则表达式校验字段是否符合规范
	 *
	 * @param key
	 *            待校验字段
	 * @param dc
	 * @param must
	 *            字段是否是必须的
	 * @throws Exception
	 */
	protected static function check($key, $map, $must) {
		$log    = new Logger();
		$value  = $map->get($key);
		$tValue = $value;
		if (empty($value)) {
			// 必须字段为空，抛出异常
			if ($must) {
				die("The parameters of the request ".$key." can't be empty");
			}
		} else {
			if (count(CheckReqDataAndEncrypt::$regexkeysarray) <= 0) {
				$log->logInfo("loading mapping_regex.ini");
				CheckReqDataAndEncrypt::$regexkeysarray = parse_ini_file("mapping_regex.ini");
			}
			$regex = CheckReqDataAndEncrypt::$regexkeysarray["Regex.".$key];
			if (empty($regex)) {
				$log->logInfo("The parameters of the request ".$key." not configured regular validation rules");
				return;
			}
			// 不符合正则表达式
			if (!preg_match($regex, $tValue)) {
				$log->logInfo("Request parameters [".$key."(".$tValue.")] format or value can not match the regular rules [".$regex."]");
				die("Request parameters [".$key."(".$tValue.")] format or value is not correct");
			} else {
				$log->logInfo("Request parameters [".$key."(".$tValue.")] format or value match the regular rules [".$regex."]");
			}
		}
	}
}

?>
