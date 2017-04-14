<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\BaseController;

class WxBaseController extends BaseController
{

    protected $appid = 'wx76728b0230778ea4';
    protected $appsecret = '9661b4bfb77880d71b49f6a26fab8155';
    //access_token
    protected $access_token;
    //微信服务器发来的数据
    protected $message;
    //API 根地址
    protected $apiUrl = 'https://api.weixin.qq.com';


    //产生随机字符串，不长于32位
    public function getRandStr( $length = 32 ) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
        for ( $i = 0; $i < $length; $i ++ ) {
            $str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
        }

        return $str;
    }

    //启动组件
    public function bootstrap() {

        $this->access_token = $this->getAccessToken();
        //处理 微信服务器 发来的数据
        $this->message = $this->parsePostRequestData();
    }

    /**
     * 发送请求,第二个参数有值时为Post请求
     *
     * @param string $url 请求地址
     * @param array $fields 发送的post表单
     *
     * @return string
     */
    public function curl( $url, $fields = [ ] ) {
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

    public function getAccessToken( $force = false ) {

        $url  = $this->apiUrl . '/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid
            . '&secret=' . $this->appsecret;
        $data = $this->curl( $url );
        $data = json_decode( $data, true );
        //获取失败
        if ( isset( $data['errcode'] ) ) {
            return false;
        }

        //获取access_token成功
        return $this->access_token = $data['access_token'];
    }


    //解析微信发来的POST/XML数据
    private function parsePostRequestData() {
        if ( isset( $GLOBALS['HTTP_RAW_POST_DATA'] ) ) {
            $post = $GLOBALS['HTTP_RAW_POST_DATA'];

            return simplexml_load_string( $post, 'SimpleXMLElement', LIBXML_NOCDATA );
        }
    }

    //微信接口整合验证进行绑定
    public function valid() {
        if ( ! isset( $_GET["echostr"] ) || ! isset( $_GET["signature"] ) || ! isset( $_GET["timestamp"] ) || ! isset( $_GET["nonce"] ) ) {
            return false;
        }
        $echoStr   = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = 'dashan';
        $tmpArr    = [ $token, $timestamp, $nonce ];
        sort( $tmpArr, SORT_STRING );
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if ( $tmpStr == $signature ) {
            //echo $echoStr;
            return true;
            exit;
        } else {
            return false;
        }
    }


}
