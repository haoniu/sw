<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\WeChat\WxBaseController as TopController;
use Hn\SwBundle\Entity\WxArticle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Hn\SwBundle\Controller\WeChat\WxPayUnifiedOrder;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class IndexController extends TopController
{

    public function indexAction()
    {
        //$this->bootstrap();
        //echo $this->access_token;
        return $this->render('HnSwBundle:WeChat/index:index.html.twig');
    }

    /**
     * 初次执行微信服务器验证
     * @return Response
     */
    public function checkAction()
    {
        //执行微信服务器验证
        $valid = $this->get('sw_wechat')->valid();
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
                    "name":"大山公众号",
                    "sub_button":[
                        {
                            "type":"view",
                            "name":"我的首页",
                            "url":"http://dashan.haoniube.com/wx"
                        },
                        {
                            "type":"view",
                            "name":"录音测试",
                            "url":"http://dashan.haoniube.com/wx/record"
                        },
                        {
                            "type":"view",
                            "name":"支付测试",
                            "url":"http://dashan.haoniube.com/wx/pay"
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
        $input->SetTotal_fee("0.01");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetOpenid($openId);
        $input->SetTrade_type('JSAPI');
        $input->SetAppid($this->appid);
        $input->SetMch_id($this->MCHID);
        $input->SetNonce_str($this->getRandStr(16));
        $xml = $this->unifiedOrder($input);

        $res = $this->curl( "https://api.mch.weixin.qq.com/pay/unifiedorder", $xml );
        $order = $this->xmlToArray($res);

        var_dump($order);

        //$jsApiParameters = $this->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        //$editAddress = $this->GetEditAddressParameters();

        return $this->render('HnSwBundle:WeChat/index:pay.html.twig',array(
            'jsApiParameters' => 1
        ));
    }


    public function recordAction(Request $request)
    {

        $jsData = $this->get('sw_wechat')->getJsSign($request->getUri());



        return $this->render('HnSwBundle:WeChat/index:record.html.twig',array(
            'jsData' => $jsData
        ));
    }

    public function ajaxUploadRecordAction(Request $request)
    {
        $media_id = $request->get('media_id');
        $name = time();
        $data = $this->wxDownloadMedia($media_id,'./wx/voice/'.$name.'.amr');
        return $this->json($data);
    }

    public function getNewsAction()
    {
        $param = [
            //素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
            "type"   => 'news',
            //从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
            "offset" => 0,
            //返回素材的数量，取值在1到20之间
            "count"  => 20
        ];
        $ddd = array();
        $valid = $this->get('sw_wechat')->lists($param);
        $em = $this->em();
//        foreach ($valid['item'] as $key => $value){
//            foreach ($value['content']['news_item'] as $k=>$v){
////                $wxArticle = new WxArticle();
////                $wxArticle->setTitle($v['title']);
////                $wxArticle->setAuthor($v['author']);
////                $wxArticle->setDigest($v['digest']);
////                $wxArticle->setContent($v['content']);
////                $wxArticle->setUrl(rtrim($v['url'],"#rd"));
////                $wxArticle->setMediaId($value['media_id']);
////                $em->persist($wxArticle);
//
//            }
////            $em->flush();
//        }
        dump($valid);exit();
        $articleData = $this->getWxArticleRepository()->findAll();
        return $this->render('HnSwBundle:WeChat/index:article.html.twig',array(
            'article' => $articleData
        ));
    }

}
