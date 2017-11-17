# umpay
# 联动支付类
test.php 为测试文件
notify.php 为测试异步通知文件

使用前需要在 src/Umpay.php 文件中修改mer_id的值为自己的商户号；将自己的私钥，与平台的证书放入src/api/cert目录中，并修改src/api/config.php文件中privatekey,platcert的值

composer require zhana0/umpay

use Ump\Umpay;

$ump = new Umpay();//构造方法默认参数为req_front_page_pay接口类型

$ump->set_pay_type();//此方法可以设置支付方式，默认参数$pay_type = 'B2CDEBITBANK', $payment_mode = ''，此方法在构造方法中已执行一次

$ump->set_order_id(date('Ymd',time()).uniqid());//设置订单号

$ump->set_mer_date(time());//设置订单日期

$ump->set_order_amount(1);//设置订单金额

$ump->set_goods_inf('测试商品');//设置商品名称（扫码支付必填）

header("Location:" . $ump->get_request_url());//生成链接，并跳转
