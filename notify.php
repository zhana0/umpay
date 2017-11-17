<?php
require __DIR__ .'/vendor/autoload.php';
use Ump\Umpay;
//获取联动平台支付结果通知数据(商户应采取循环遍历方式获取平台通知数据,不应采取固定编码的方式获取固定字段，
//否则当平台通知数据发生变化时，容易出现接收数据验签不通过情况)
$map = new HashMap();
foreach($_REQUEST as $key => $value){
    $map->put($key,$value);
}
//获取UMPAY平台请求商户的支付结果通知数据,并对请求数据进行验签,此时商户接收到的支付结果通知会存放在这里,商户可以根据此处的trade_state订单状态来更新订单。
$resData = new HashMap ();
try{
    //如验证平台签名正确，即应响应UMPAY平台返回码为0000。【响应返回码代表通知是否成功，和通知的交易结果（支付失败、支付成功）无关】
    //验签支付结果通知 如验签成功，则返回ret_code=0000
    $reqData = PlatToMer::getNotifyRequestData ( $map );
        /**
         * Payment is successful
         * 进行付款正确的操作
         */
} catch (Exception $e){
    //如果验签失败，则抛出异常，返回ret_code=1111
    $resData->put("ret_code","1111");
}

//验签后的数据都组织在resData中。
//生成平台响应UMPAY平台数据,将该串放入META标签，以下几个参数为结果通知必备参数，实际响应参数请参照接口规范填写。
$resData->put ( "mer_id", $map->get ( "mer_id" ) );
$resData->put ( "sign_type", $map->get ( "sign_type" ) );
$resData->put ( "version", $map->get ( "version" ) );
$resData->put ( "ret_msg", "success" );

$data = MerToPlat::notifyResponseData ( $resData );

$html = '<head>';
$html .='<META NAME="MobilePayPlatform" CONTENT="'.$data.'">';
$html .='<title>result</title>';
$html .='</head>';

echo $html;
