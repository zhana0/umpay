<?php
namespace api;
require_once 'mer2PlatUtil.php';

Class MerToPlat {
	/**
	 * V4.0以GET请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function makeRequestDataByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->makeRequestData(plat_pay_product_name, $map, method_get);
		return $reqData;
	}
	/**
	 * V4.0以POST请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function makeRequestDataByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->makeRequestData(plat_pay_product_name, $map, method_post);
		return $reqData;
	}

	/**
	 * V4.0以GET请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function requestTransactionsByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getRequestData(plat_pay_product_name, $map, method_get);
		return $reqData;
	}
	/**
	 * V4.0以POST请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function requestTransactionsByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getRequestData(plat_pay_product_name, $map, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function webReqPayByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_webReqPay, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取统一支付方式请求数据
	 * 参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function webReqPayByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_webReqPay, method_post);
		return $reqData;
	}

	/**
	 * 以GET请求方式,获取后台直连请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function directPayByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_directPay, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式,获取后台直连请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function directPayByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_directPay, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取直连网银请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function reqWyByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_webDirectWyPay, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取直连网银请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，统一支付页面
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function reqWyByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_webDirectWyPay, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式查询用户交易信息,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户查询用户交易记录接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function queryTransByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_queryTrans, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式查询用户交易信息,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户查询用户交易记录接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function queryTransByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_queryTrans, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取撤销请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户撤销交易接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function cancelByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_merCancel, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取撤销请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户撤销交易接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function cancelByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_merCancel, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取退费请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户退费接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function refundByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_merRefund, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取退费请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户退费接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function refundByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_merRefund, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取交易对账文件请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function transBillByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_transBill, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取交易对账文件请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function transBillByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_transBill, method_post);
		return $reqData;
	}
	/**
	 * 以GET请求方式获取清算对账文件请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：清算数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function settleBillByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_settleBill, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取清算对账文件请求数据,参数详见《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：清算数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function settleBillByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_settleBill, method_post);
		return $reqData;
	}

	/**
	 * 以GET请求方式向微支付下单请求数据,详见：《UMPAY_SW_支付业务_微支付商户接入规范》商户向平台下订单
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function microPayReqByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_micropay_product_name, $map, funcode_microPayReq, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式向微支付下单请求数据,详见：《UMPAY_SW_支付业务_微支付商户接入规范》商户向平台下订单
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function microPayReqByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_micropay_product_name, $map, funcode_microPayReq, method_post);
		return $reqData;
	}
	/**
	 * 微支付撤销GET方式请求数据,详见：《UMPAY_SW_支付业务_微支付商户接入规范》商户撤销交易接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function microPayCancelByGet($map) {
		return self::cancelByGet($map);
	}
	/**
	 * 微支付撤销POST方式请求数据,详见：《UMPAY_SW_支付业务_微支付商户接入规范》商户撤销交易接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function microPayCancelByPost($map) {
		return self::cancelByPost($map);
	}
	/**
	 * 以GET请求方式获取话费对账文件请求数据,参数详见《UMPAY_SW_支付业务_微支付商户接入规范》文档：交易数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function billFileHfByGet($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_billFileHf, method_get);
		return $reqData;
	}
	/**
	 * 以POST请求方式获取话费对账文件请求数据,参数详见《UMPAY_SW_支付业务_微支付商户接入规范》文档：交易数据对帐接口
	 * @param $map	请求数据,数据类型:HashMap
	 * @return 请求数据对象ReqData
	 */
	public static function billFileHfByPost($map) {
		$util    = new ReqDataUtil();
		$reqData = $util->getReqData(plat_pay_product_name, $map, funcode_billFileHf, method_post);
		return $reqData;
	}
	/**
	 * 3.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param $map
	 * @return 商户响应平台数据
	 */
	public static function notifyResData($map) {
		$plain = NotifyResData::getNotifyResDataPlain($map);
		$sign  = SignUtil::sign($plain);
		return $plain."|".$sign;
	}

	/**
	 * 4.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param $map
	 * @return 商户响应平台数据
	 */
	public static function notifyResponseData($map) {
		$plain = NotifyResData::getNotifyResponseDataPlain($map);
		$merId = $map->get('mer_id');
		$sign  = SignUtil::sign($plain, $merId);
		$plain = StringUtil::getSortParameter($map);
		return $plain."&sign=".$sign;
	}
	/**
	 * 4.0接口商户响应平台退款结果通，检查数据字段合法性并生成签名明文串
	 * @param $map
	 * @return 商户响应平台数据
	 */
	public static function RefundnotifyResponseData($map) {
		$plain = NotifyResData::getRefundNotifyResponseDataPlain($map);
		$merId = $map->get('mer_id');
		$sign  = SignUtil::sign($plain, $merId);
		$plain = StringUtil::getSortParameter($map);
		return $plain."&sign=".$sign;
	}
	/**
	 * 4.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param $map
	 * @return 商户响应平台数据
	 */
	public static function notifySplitRequestResData($map) {
		$plain = NotifyResData::getSplitRequestNotifyResDataPlain($map);
		$sign  = SignUtil::sign($plain);
		$plain = StringUtil::getSortParameter($map);
		return $plain."&sign=".$sign;
	}
	/**
	 * 4.0接口商户响应平台支付结果通知(商户到平台，直连网银)检查数据字段合法性并生成签名明文串
	 * @param $map
	 * @return 商户响应平台数据
	 */
	public static function notifySplitMerRefundResData($map) {
		$plain = NotifyResData::getSplitMerRefundNotifyResDataPlain($map);
		$sign  = SignUtil::sign($plain);
		$plain = StringUtil::getSortParameter($map);
		return $plain."&sign=".$sign;
	}
}
?>