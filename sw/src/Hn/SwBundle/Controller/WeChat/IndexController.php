<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\WeChat\WxBaseController as TopController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Hn\SwBundle\Controller\WeChat\WxPayUnifiedOrder;

class IndexController extends TopController
{

    public function indexAction()
    {
        $this->bootstrap();
        echo $this->access_token;
        return $this->render('HnSwBundle:WeChat/index:index.html.twig');
    }

    /**
     * 初次执行微信服务器验证
     * @return Response
     */
    public function checkAction()
    {
        //执行微信服务器验证
        $valid = $this->valid();
        return new Response($valid);
    }

    /**
     * 创建菜单
     * @return Response
     */
    public function createWxMenuAction()
    {
        $jsonmenu = '{
            "button":[
                {
                    "name":"跳转",
                    "sub_button":[
                        {
                            "type":"view",
                            "name":"我的商城",
                            "url":"http://dashan.haoniube.com/wx"
                        }
                    ]
                },
            ]
        }';
        $url     = $this->apiUrl . '/cgi-bin/menu/create?access_token=' . $this->getAccessToken();
        $content = $this->curl( $url, $jsonmenu );

        $finlData = $this->checkData($content);
        return new JsonResponse($finlData);
    }

    public function payAction()
    {
        //获取用户的openId
        $openId = $this->getOpenId();

        //统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no($this->MCHID.date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetOpenid($openId);

        $order = $this->hnunifiedOrder($input);

        var_dump($order);

        //$jsApiParameters = $this->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        //$editAddress = $this->GetEditAddressParameters();

        return $this->render('HnSwBundle:WeChat/index:pay.html.twig',array(
            'jsApiParameters' => 1
        ));
    }
}
