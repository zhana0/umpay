<?php
/**
 * Created by PhpStorm.
 * User: zhana0
 * Date: 17-9-25
 * Time: 下午1:31
 */
namespace Ump;
use api\HashMap;
use api\MerToPlat;

class Umpay {

	//基本参数
	protected $config = [
		'service'        => '', //接口类型，构造方法赋值
		'charset'        => 'UTF-8',
		'mer_id'         => '88888', //商户号
		'sign_type'      => 'RSA',
		'ret_url'        => 'http://home/pay/ret_url', //同步回调地址
		'notify_url'     => 'http://home/pay/notify_url', //异步通知地址
		'res_format'     => 'HTML',
		'version'        => '4.0',
		'amt_type'       => 'RMB',
		'interface_type' => '01'
	];

	public function __construct($service = 'req_front_page_pay') {
		$this->config['service'] = $service;
		$this->set_pay_type();
	}

	//设置订单信息
	public function set_order_data($order) {
		$this->config['order_id'] = $order['order_sn'];
		$this->config['mer_date'] = date('Ymd', $order['add_time']);
		$this->config['amount']   = $order['order_amount']*100;

		//通过订单号获取订单内商品名称用于扫码支付
		$this->config['goods_inf'] = $order['goods_name'];
	}

	//设置订单号
	public function set_order_id($order_id) {
		$this->config['order_id'] = $order_id;
	}

	//设置订单日期
	public function set_mer_date($date) {
		$this->config['mer_date'] = date('Ymd', $date);
	}

	//设置订单金额
	public function set_order_amount($amount) {
		$this->config['amount'] = $amount*100;
	}

	//设置购买商品名称
	public function set_goods_inf($info) {
		$this->config['goods_inf'] = $info;
	}

	//设置支付方式
	public function set_pay_type($pay_type = 'B2CDEBITBANK', $payment_mode = '') {
		$this->config['pay_type'] = $pay_type;

		//微信支付宝支付 01 微信扫码 02 支付宝扫码
		if ($payment_mode) {
			$this->config['payment_mode'] = $payment_mode;
		}
	}

	//获取提交地址
	public function get_request_url() {
        $map = new HashMap();
        foreach ($this->config as $k => $v) {
            if (!$v) {//验证参数是否完整
                return false;
            }
            $map->put($k, $v);
        }
        $reqDataGet = MerToPlat::makeRequestDataByGet($map);
        return $reqDataGet->getUrl();
	}

	//输出配置
	public function get_config() {
		return $this->config;
	}

}
