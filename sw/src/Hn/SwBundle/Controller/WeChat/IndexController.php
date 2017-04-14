<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\WeChat\WxBaseController as TopController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        return $this->render('HnSwBundle:WeChat/index:pay.html.twig');
    }
}
