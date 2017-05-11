<?php
namespace Hn\SwBundle\Services\AliPay;

use Hn\SwBundle\Services\AliPay\WapPayModel\AlipayTradeWapPayContentBuilder;
use Hn\SwBundle\Services\AliPay\AlipayTradeService;
use Hn\SwBundle\Loader;

class HnPay
{
    //开始支付
    public function pay( ) {

        $config = Loader\ConfigLoader::load('ali');

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = 'AHN1234567811';

        //订单名称，必填
        $subject = 'da';

        //付款金额，必填
        $total_amount = 0.01;

        //商品描述，可空
        $body = '测试商品';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new AlipayTradeService($config);
        $result= $payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

        return $result;
    }
}