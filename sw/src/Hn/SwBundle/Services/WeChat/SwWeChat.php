<?php

namespace Hn\SwBundle\Services\WeChat;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Hn\SwBundle\Services\WeChat\Error\Error;

class SwWeChat extends Error
{
    private $container;

    protected $appid;                                           //微信应用ID

    protected $appsecret;                                       //微信应用密钥

    protected $access_token;                                    //微信access_token

    protected $token;                                           //个人定义的token

    protected $message;                                         //微信服务器发来的数据

    protected $apiUrl = 'https://api.weixin.qq.com';            //API 根地址

    public function __construct($container)
    {
        $this->container = $container;
        $this->bootstrap();
    }

    /**
     * 启动组件
     */
    public function bootstrap()
    {
        $WeChatConfig = $this->container->getParameter('wechat');

        $this->appid        = $WeChatConfig['appid'];
        $this->appsecret    = $WeChatConfig['appsecret'];
        $this->token        = $WeChatConfig['token'];

        $this->access_token = $this->getAccessToken();          //获取access_token
        $this->message = $this->parsePostRequestData();         //处理 微信服务器 发来的数据
    }

    public function test()
    {
        var_dump($this->appid);
    }

    /**
     * 微信接口整合验证进行绑定
     * @return string
     */
    public function valid() {
        if ( ! isset( $_GET["echostr"] ) || ! isset( $_GET["signature"] ) || ! isset( $_GET["timestamp"] ) || ! isset( $_GET["nonce"] ) ) {
            return 'false';
        }
        $echoStr   = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = $this->token;
        $tmpArr    = [ $token, $timestamp, $nonce ];
        sort( $tmpArr, SORT_STRING );
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if ( $tmpStr == $signature ) {
            echo $echoStr;
            exit;
        } else {
            return 'false';
        }
    }

    /**
     * 解析微信数据
     * @return \SimpleXMLElement
     */
    private function parsePostRequestData() {
        if ( isset( $GLOBALS['HTTP_RAW_POST_DATA'] ) ) {
            $post = $GLOBALS['HTTP_RAW_POST_DATA'];

            return simplexml_load_string( $post, 'SimpleXMLElement', LIBXML_NOCDATA );
        }
    }
    /**
     * 获取access_token
     * 文档地址：https://mp.weixin.qq.com/wiki/15/54ce45d8d30b6bf6758f68d2e95bc627.html
     * @return bool|mixed
     */
    public function getAccessToken()
    {
        $cache = new FilesystemAdapter();

        // 取出缓存元素
        $wxToken = $cache->getItem('wx.accessToken');
        if (!$wxToken->isHit()) {
            //元素在缓存中不存在
            $url  = $this->apiUrl . '/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid
                . '&secret=' . $this->appsecret;
            $data = $this->curl( $url );
            $data = json_decode( $data, true );
            //获取失败
            if ( isset( $data['errcode'] ) ) {
                return false;
            }
            $wxToken->set($data['access_token']);
            $wxToken->expiresAfter(3600);
            $cache->save($wxToken);
            $token = $data['access_token'];
        }else{
            $token = $wxToken->get();
        }

        //获取access_token成功
        return $token;
    }


    /**
     *
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     *
     * @return 用户的openid
     */
    public function getOpenId($return_url)
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode($return_url);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $openid = $this->getOpenidFromMp($code);
            return $openid;
        }
    }



    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return 返回构造好的url
     */
    private function __CreateOauthUrlForCode($redirectUrl)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = "snsapi_base";
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }

    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code)
    {
        $url = $this->__CreateOauthUrlForOpenid($code);

        $res = $this->curl($url);

        //取出openid
        $data = json_decode($res,true);
        //$this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }

    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["secret"] = $this->appsecret;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }



    //获取素材列表
    public function lists( $param ) {
        $url     = $this->apiUrl . "/cgi-bin/material/batchget_material?access_token={$this->access_token}";
        $content = $this->curl( $url, json_encode( $param, JSON_UNESCAPED_UNICODE ) );

        return $this->getData( $content );
    }

    public function createWxMenu()
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
        $url     = $this->apiUrl . '/cgi-bin/menu/create?access_token=' . $this->access_token;
        $content = $this->curl( $url, $jsonmenu );

        $finlData = $this->getData($content);
        return $finlData;
    }

    /**
     * 获得jsapi_ticket
     * 文档地址：https://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html#.E9.99.84.E5.BD.951-JS-SDK.E4.BD.BF.E7.94.A8.E6.9D.83.E9.99.90.E7.AD.BE.E5.90.8D.E7.AE.97.E6.B3.95
     * @return mixed|string
     */
    public function getJsTicket()
    {
        $cache = new FilesystemAdapter();

        // 取出缓存元素
        $wxTicket = $cache->getItem('wx.jsTicket');
        if (!$wxTicket->isHit()) {
            //元素在缓存中不存在，请求的api地址是：https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
            $url  = $this->apiUrl . '/cgi-bin/ticket/getticket?access_token=' . $this->getAccessToken() . '&type=jsapi';

            $data = $this->curl( $url );
            $data = json_decode( $data, true );
            //获取失败
            if ( $data['errcode'] != 0 ) {
                return '失败';
            }
            $wxTicket->set($data['ticket']);
            $wxTicket->expiresAfter(3600);  //设置缓存时间
            $cache->save($wxTicket);
            $ticket = $data['ticket'];
        }else{
            $ticket = $wxTicket->get();
        }

        return $this->js_ticket = $ticket;
    }

    /**
     * 获得令牌签名
     * @param $randstr          随机字符串
     * @param $time             时间戳
     * @param $url              url地址
     * @return string
     */
    public function getTicketSign($randstr,$time,$url)
    {
        $ticket = $this->getJsTicket();
        $string1 = 'jsapi_ticket='.$ticket.'&noncestr='.$randstr.'&timestamp='.$time.'&url='.$url;
        return sha1($string1);
    }

    /**
     *  返回js签名数据
     * @param $url
     * @return array
     */
    public function getJsSign($url)
    {
        $jsData = array();
        $jsData['appid'] = $this->appid;
        $jsData['timestamp'] = time();
        $jsData['nonceStr'] = $this->getRandStr(12);
        $jsData['signature'] = $this->getTicketSign($jsData['nonceStr'],$jsData['timestamp'],$url);
        return $jsData;
    }




    /**------------------------------------------工具类--------------------------------------------------------------**/

    /**
     * 将xml转为array,不分析XML属性等数据
     *
     * @param $xml
     *
     * @return mixed
     * @throws \Exception
     */
    public function xmlToArray( $xml ) {
        if ( ! $xml ) {
            throw new \Exception( "xml数据异常！" );
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader( true );

        return json_decode( json_encode( simplexml_load_string( $xml, 'SimpleXMLElement', LIBXML_NOCDATA ) ), true );
    }

    /**
     * 生成xml字符,不能分析复杂的XML数据比如有属性的XML
     *
     * @param $data
     * @param int $level
     *
     * @return string
     * @throws \Exception
     */
    public function arrayToXml( $data, $level = 0 ) {
        if ( ! is_array( $data )
            || count( $data ) <= 0
        ) {
            throw new \Exception( "数组数据异常！" );
        }
        if ( $level == 0 ) {
            $xml = "<xml>";
        }
        foreach ( $data as $key => $val ) {
            if ( is_array( $val ) ) {
                $xml .= "<" . $key . ">" . $this->toSimpleXml( $val, 1 ) . "</" . $key . ">";
            } else if ( is_numeric( $val ) ) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        if ( $level == 0 ) {
            $xml .= "</xml>";
        }

        return $xml;
    }

    /**
     * 发送请求,第二个参数有值时为Post请求
     *
     * @param string $url 请求地址
     * @param array $fields 发送的post表单
     *
     * @return string
     */
    public function curl( $url, $fields = [ ] )
    {
        $ch = curl_init();
        //设置我们请求的地址
        curl_setopt( $ch, CURLOPT_URL, $url );
        //数据返回后不要直接显示
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        //禁止证书校验
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        if ( $fields ) {
            curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );
        }
        $data = '';
        if ( curl_exec( $ch ) ) {
            //发送成功,获取数据
            $data = curl_multi_getcontent( $ch );
        }
        curl_close( $ch );

        return $data;
    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 产生随机字符串，不长于32位
     *
     * @param int $length       定义产生随机字符串长度
     * @return string
     */
    public function getRandStr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
        for ( $i = 0; $i < $length; $i ++ ) {
            $str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
        }

        return $str;
    }

}