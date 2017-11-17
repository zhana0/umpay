<?php
require __DIR__ .'/vendor/autoload.php';
use Ump\Umpay;
$ump = new Umpay();
//设置订单号
$ump->set_order_id(data('Ymd',time()).unique());
//设置订单日期
$ump->set_mer_date(time());
//设置订单金额
$ump->set_order_amount(1);
//设置商品名称（扫码支付必填）
$ump->set_goods_inf('测试商品');
//生成支付链接，并跳转
header("Location://" . $ump->get_request_url());
