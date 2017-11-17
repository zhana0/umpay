<?php
namespace api;
require_once 'plat2MerUtil.php';
/**
 * 解析后台直连平台响应结果
 * @author xuchaofu
 * 	2010-04-01
 */
Class PlatToMer {

	/**
	 * V4.0解析后台直连支付UMPAY平台响应商户HTML，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getResDataByHtml($html) {
		return PlatToMerUtil::getDataByHtmlForV4($html, fields_directreqpay);
	}
	/**
	 * V4.0解析后台直连支付UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getResDataByMeta($meta) {
		return PlatToMerUtil::getDataByMetaForV4($meta, fields_directreqpay);
	}
	/**
	 * 解析后台直连支付UMPAY平台响应商户HTML，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getDirectPayByHtml($html) {
		return PlatToMerUtil::getDataByHtml($html, fields_directreqpay);
	}
	/**
	 * 解析后台直连支付UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档:商户向平台下订单接口，后台直连
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getDirectPayByMeta($meta) {
		return PlatToMerUtil::getDataByMeta($meta, fields_directreqpay);
	}

	/**
	 * 解析查询用户交易信息UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户查询用户交易记录接口
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getQueryTransByHtml($html) {
		return PlatToMerUtil::getDataByHtml($html, fields_querytrans);
	}
	/**
	 * 解析查询用户交易信息UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户查询用户交易记录接口
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getQueryTransByMeta($meta) {
		return PlatToMerUtil::getDataByMeta($meta, fields_querytrans);
	}

	/**
	 * 解析商户撤销UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户撤销交易接口
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getCancelByHtml($html) {
		return PlatToMerUtil::getDataByHtml($html, fields_cancel);
	}
	/**
	 * 解析查商户撤销UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户撤销交易接口
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getCancelByMeta($meta) {
		return PlatToMerUtil::getDataByMeta($meta, fields_cancel);
	}
	/**
	 * 解析商户退费UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户退费接口
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getRefundByHtml($html) {
		return PlatToMerUtil::getDataByHtml($html, fields_refund);
	}
	/**
	 * 解析查商户退费UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：商户退费接口
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getRefundByMeta($meta) {
		return PlatToMerUtil::getDataByMeta($meta, fields_refund);
	}
	/**
	 * 解析微支付商户撤销UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_微支付商户接入规范》商户撤销交易接口
	 * @param html 平台响应html
	 * @return 响应数据HashMap
	 */
	public static function getMicroPayCancelByHtml($html) {
		//		return PlatToMerUtil::getDataByHtml($html,fields_micorpay_cancel);
		return self::getCancelByHtml($html);
	}
	/**
	 * 解析微支付商户撤销UMPAY平台响应商户数据，并对响应数据进行签名验签
	 * 响应字段见：《UMPAY_SW_支付业务_微支付商户接入规范》商户撤销交易接口
	 * @param meta 平台响应HTML中meta标签CONTENT属性的值,格式:数值项|数值项|...|数值项|签名
	 * @return 响应数据HashMap
	 */
	public static function getMicroPayCancelByMeta($meta) {
		//return PlatToMerUtil::getDataByMeta($meta,fields_micorpay_cancel);
		return self::getCancelByMeta($meta);
	}

	/**
	 * 获取UMPAY平台通知商户请求数据,并对请求数据进行验签
	 * 字段信息详见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易结果通知接口请求数据
	 * @param  $map平台请求数据
	 * @return HashMap平台通知商户数据
	 */
	public static function getNotifyReqData($map) {
		return PlatToMerUtil::getNotifyReqData($map);
	}
	/**
	 * V4.0获取UMPAY平台通知商户请求数据,并对请求数据进行验签
	 * 字段信息详见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易结果通知接口请求数据
	 * @param  $map平台请求数据
	 * @return HashMap平台通知商户数据
	 */
	public static function getNotifyRequestData($map) {
		$service = StringUtil::trim($map->get("service"));
		if ("split_refund_result" == $service) {
			return PlatToMerUtil::getSplitMerRefundNotifyReqData($map);
		} else {
			return PlatToMerUtil::getNotifyRequestData($map);
		}
	}
	/**
	 * V4.0获取UMPAY平台通知商户分账请求数据,并对请求数据进行验签
	 * 字段信息详见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易结果通知接口请求数据
	 * @param  $map平台请求数据
	 * @return HashMap平台通知商户数据
	 */
	public static function getSplitRequestNotifyReqData($map) {
		return PlatToMerUtil::getSplitRequestNotifyReqData($map);
	}
	/**
	 * V4.0获取UMPAY平台通知商户分账退费请求数据,并对请求数据进行验签
	 * 字段信息详见：《UMPAY_SW_支付业务_手机银行卡商户接入规范》文档：交易结果通知接口请求数据
	 * @param  $map平台请求数据
	 * @return HashMap平台通知商户数据
	 */
	public static function getSplitMerRefundNotifyReqData($map) {
		return PlatToMerUtil::getSplitMerRefundNotifyReqData($map);
	}
}
?>