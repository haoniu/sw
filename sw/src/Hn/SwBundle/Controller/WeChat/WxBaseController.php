<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use WxPayResults;
use WxPayJsApiPay;
use WxPayException;
class WxBaseController extends BaseController
{

    protected $MCHID = '1';
    protected $KEY = '1';

    protected $appid = '1';
    protected $appsecret = '1';
    //access_token
    protected $access_token;

    protected $js_ticket;
    //微信服务器发来的数据
    protected $message;
    //API 根地址
    protected $apiUrl = 'https://api.weixin.qq.com';


    //产生随机字符串，不长于32位
    public function getRandStr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str   = "";
        for ( $i = 0; $i < $length; $i ++ ) {
            $str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
        }

        return $str;
    }

    //启动组件
    public function bootstrap()
    {

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
        return $this->access_token = $token;
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

    public function getTicketSign($randstr,$time,$url)
    {
        $ticket = $this->getJsTicket();
        $string1 = 'jsapi_ticket='.$ticket.'&noncestr='.$randstr.'&timestamp='.$time.'&url='.$url;
        return sha1($string1);
    }

    public function getJsSign($url)
    {
        $jsData = array();
        $jsData['appid'] = $this->appid;
        $jsData['timestamp'] = time();
        $jsData['nonceStr'] = $this->getRandStr(12);
        $jsData['signature'] = $this->getTicketSign($jsData['nonceStr'],$jsData['timestamp'],$url);
        return $jsData;
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
            return 'false';
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
            echo $echoStr;
            exit;
        } else {
            return 'false';
        }
    }

    //根据微信服务器返回信息，验证是否发生错误，如果有错误，根据errcode值返回具体错误内容
    public function checkData( $data ) {
        $data = json_decode( $data, true );
        if ( ! is_array( $data ) || ! array_key_exists( 'errcode', $data ) ) {
            return $data;
        } else if ( $data['errcode'] == 0 ) {
            return $data;
        } else if ( isset( $this->error[ $data['errcode'] ] ) ) {
            $errmsg = isset( $this->error[ $data['errcode'] ] ) ? $this->error[ $data['errcode'] ] : ( $data['errmsg'] ?: '未知错误' );

            return [ 'errcode' => $data['errcode'], 'errmsg' => $errmsg ];
        }

        return $data;
    }

    //获取用户信息的openId
//    public function getOpenId() {
//        $url  = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->appid . "&secret=" . $this->appsecret . "&code=" . q( 'get.code' ) . "&grant_type=authorization_code";
//        $d    = $this->curl( $url );
//        $data = $this->checkData( $d );
//
//        return isset( $data['errcode'] ) ? false : $data;
//    }


    public $data = null;

    /**
     *
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     *
     * @return 用户的openid
     */
    public function getOpenId()
    {
        //通过code获得openid
        if (!isset($_GET['code'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://dashan.haoniube.com/wx/pay');
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







    //统一下单
    protected function hnunifiedorder( $data ) {
        $data['appid']      = $this->appid;
        $data['mch_id']     = $this->MCHID;
        $data['nonce_str']  = $this->getRandStr( 16 );
        $data['trade_type'] = 'JSAPI';
        //$data['sign']       = $this->makeSign( $data );
        $xml                = $this->arrayToXml( $data );
        $res                = $this->curl( "https://api.mch.weixin.qq.com/pay/unifiedorder", $xml );

        return $this->xmlToArray( $res );
    }



    //生成签名,支付或红包等使用
    public function makeSign( $data ) {
        //签名步骤一：按字典序排序参数
        ksort( $data );
        $string = $this->ToUrlParams( $data );
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $this->KEY;
        //签名步骤三：MD5加密
        $string = md5( $string );
        //签名步骤四：所有字符转为大写
        $result = strtoupper( $string );

        return $result;
    }



    /**
     *
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public static function unifiedOrder($inputObj, $timeOut = 6)
    {
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        //检测必填参数
        if(!$inputObj->IsOut_trade_noSet()) {
            throw new \Exception("缺少统一支付接口必填参数out_trade_no！");
        }else if(!$inputObj->IsBodySet()){
            throw new \Exception("缺少统一支付接口必填参数body！");
        }else if(!$inputObj->IsTotal_feeSet()) {
            throw new \Exception("缺少统一支付接口必填参数total_fee！");
        }else if(!$inputObj->IsTrade_typeSet()) {
            throw new \Exception("缺少统一支付接口必填参数trade_type！");
        }

        //关联参数
        if($inputObj->GetTrade_type() == "JSAPI" && !$inputObj->IsOpenidSet()){
            throw new \Exception("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！");
        }
        if($inputObj->GetTrade_type() == "NATIVE" && !$inputObj->IsProduct_idSet()){
            throw new \Exception("统一支付接口中，缺少必填参数product_id！trade_type为JSAPI时，product_id为必填参数！");
        }

        //异步通知url未设置，则使用配置文件中的url
//        if(!$inputObj->IsNotify_urlSet()){
//            $inputObj->SetNotify_url(WxPayConfig::NOTIFY_URL);//异步通知url
//        }

        //$inputObj->SetAppid('wx76728b0230778ea4');//公众账号ID
        //$inputObj->SetMch_id(WxBaseController::getMCHID());//商户号
        $inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
        //$inputObj->SetSpbill_create_ip("1.1.1.1");
        //$inputObj->SetNonce_str(WxBaseController::getRandStr(16));//随机字符串

        //签名
        $inputObj->SetSign();
        $xml = $inputObj->ToXml();

        //$startTimeStamp = self::getMillisecond();//请求开始时间
        //$response = self::postXmlCurl($xml, $url, false, $timeOut);
        //$result = WxPayResults::Init($response);
        //self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间

        //$res = WxBaseController::curl( "https://api.mch.weixin.qq.com/pay/unifiedorder", $xml );

        return $xml ;
    }






    public function wxDownloadMedia( $media_id, $file ) {
        $url    = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$this->getAccessToken()}&media_id=$media_id";
        $result = $this->curl( $url );
        $dir    = dirname( $file );
        is_dir( $dir ) || mkdir( $dir, 0755, true );

        return file_put_contents( $file, $result );
    }



/**------------------------------------------------------------------------------------------------------------------**/




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
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
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







    /**
     * 获取毫秒级别的时间戳
     */
    private static function getMillisecond()
    {
        //获取毫秒的时间戳
        $time = explode ( " ", microtime () );
        $time = $time[1] . ($time[0] * 1000);
        $time2 = explode( ".", $time );
        $time = $time2[0];
        return $time;
    }

    /**
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }


    /**
     *
     * 上报数据， 上报的时候将屏蔽所有异常流程
     * @param string $usrl
     * @param int $startTimeStamp
     * @param array $data
     */
    private static function reportCostTime($url, $startTimeStamp, $data)
    {
        //如果不需要上报数据
        if(WxPayConfig::REPORT_LEVENL == 0){
            return;
        }
        //如果仅失败上报
        if(WxPayConfig::REPORT_LEVENL == 1 &&
            array_key_exists("return_code", $data) &&
            $data["return_code"] == "SUCCESS" &&
            array_key_exists("result_code", $data) &&
            $data["result_code"] == "SUCCESS")
        {
            return;
        }

        //上报逻辑
        $endTimeStamp = self::getMillisecond();
        $objInput = new WxPayReport();
        $objInput->SetInterface_url($url);
        $objInput->SetExecute_time_($endTimeStamp - $startTimeStamp);
        //返回状态码
        if(array_key_exists("return_code", $data)){
            $objInput->SetReturn_code($data["return_code"]);
        }
        //返回信息
        if(array_key_exists("return_msg", $data)){
            $objInput->SetReturn_msg($data["return_msg"]);
        }
        //业务结果
        if(array_key_exists("result_code", $data)){
            $objInput->SetResult_code($data["result_code"]);
        }
        //错误代码
        if(array_key_exists("err_code", $data)){
            $objInput->SetErr_code($data["err_code"]);
        }
        //错误代码描述
        if(array_key_exists("err_code_des", $data)){
            $objInput->SetErr_code_des($data["err_code_des"]);
        }
        //商户订单号
        if(array_key_exists("out_trade_no", $data)){
            $objInput->SetOut_trade_no($data["out_trade_no"]);
        }
        //设备号
        if(array_key_exists("device_info", $data)){
            $objInput->SetDevice_info($data["device_info"]);
        }

        try{
            self::report($objInput);
        } catch (WxPayException $e){
            //不做任何处理
        }
    }




    /**
     *
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @throws WxPayException
     *
     * @return json数据，可直接填入js函数作为参数
     */
    public function GetJsApiParameters($UnifiedOrderResult)
    {
        if(!array_key_exists("appid", $UnifiedOrderResult)
            || !array_key_exists("prepay_id", $UnifiedOrderResult)
            || $UnifiedOrderResult['prepay_id'] == "")
        {
            throw new WxPayException("参数错误");
        }
        $jsapi = new WxPayJsApiPay();
        $jsapi->SetAppid($UnifiedOrderResult["appid"]);
        $timeStamp = time();
        $jsapi->SetTimeStamp("$timeStamp");
        $jsapi->SetNonceStr($this->getRandStr());
        $jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);
        $jsapi->SetSignType("MD5");
        $jsapi->SetPaySign($jsapi->MakeSign());
        $parameters = json_encode($jsapi->GetValues());
        return $parameters;
    }


}
