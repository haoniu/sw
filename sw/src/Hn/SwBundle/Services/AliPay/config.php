<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017050807157703",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAvBEiBcJo24Mg+yT3Ge/uSAAHIosHiVQPXLyruJxGCPikOdNKejlLB3qVvxzR+lq1tVdEU2thiBX+/O2fouYvGCxVTzAoYtimGRGZtk5XQ16LVWc6RQRKRfMVl0B8btB/kJRgO4k6jatfBnZeeSC6YNfdOMTDFr8/0EGvDjjE0nhfglQIuDkFoBjK91b9Di6DIC+5oK0devqfRZtuKS0kL6UKAvskCz6eLazRlBAwk9oqzAkSiGruW+snBveW1WfSst1K0fmlGAwG3Ry3NkqDeEt8VbKR2jV6vprs3HIffNjQqGrDVH0YOXS9FOPs9GhKffY6S5hVumJmgFFKSTCjAQIDAQABAoIBAAqF3uR5m0plDOxghh8CaM/IiJ2rL9HETVPADs+2lsibuPyvUOSD3ind9xEJeMpMVwx9hIoyYPOvX2Qhm6QOwyXUHTXgGPJm8uxGKtajjYhsetldfEouUkWVs2iSKCQ/MFQTqUrLg+Y3Z4rCBsk6RpNyoKMzh0L3koeBlVzzWjf4gbCm/81towHgup2s5tD7XEy+8MhOXixo6zx53HU7rUGceXP4nK1WoxUZGjUZNUydVRUxVjXBvGis+llfo9/2KOkbFGJlFymYlreiFZFmJ3OTQRLQisLPbRDKHo8xXatRpWRT56Sco8LgV5KEPP6V4RyUcqZKa9fPc0/jJXUJPk0CgYEA52gs/jZANqpl0TMMC/+Xgb1IXFiF/9ToUtFgLUZM2NQ/YHkmWyE3xCUfYP9SrglmICeI50bNz/tS+O07LjEZ6sSDnnrCBMd7wNSQHBFjFYDSi228hV2eClX3Dg+DcQ8t9bk0CdFvXzYTQIsLQSWrDwp3fhpB27FjMbGKN08UPg8CgYEA0A3RR8XMYLDiEG1pIsVqKqNA5WXP9Qijq+3WPYdX6u1AujE8RUCkLZ3d+zaa2wE6m4kJCrerWUUPxBoEFpImnGBIrLn3x4BDLe7NcnrcnoE7UlvOSSDqYlyMvP1jETvwelERufbr6GEhgeyA86gAny4iAk1T0IQN/3Kp8ESNHe8CgYEA4qeAAlKi3KhT5+8G6q2i+RmryX+PaEBiedPITzAfTvW9ScIAFpxXoc/2hywuEHb2R6JRjq4kIoV5BIZgQ+MmDnQCsvRsGwBEr1/D8yn4kfRGxPhsAXjrthXzURtS1CdZDegkF0XCv1AY1Uwbbuj1PlszJRmUzhlWHjNWPMxA+HMCgYEAlI1pIsAen+NsZqJYcVVX6r3KNoEtrR3QD5CwahpbMgjZMJi7Gg9/qnqP5zEj/L+x4yBDbn2aQRFIopKY3KzaGMm+2mWmf7IbRY6+7sC/CgXoH3QhpKF1+Wlvq/mYZNPRbuS3rXqbEr9Xt3bw1Aje+Mltywr/j2DaxcxPfpjT0c0CgYA2d6xsuffblp3PwmZF1YOrNez423xM0Y6y66nSqXNgCqIJ0nAVndQO+4wEo7cQr0dzFl7+Aru5o4KYoG4tTRy4ZArg61H3j0v/Y1NLffb/PkJzP3sSxsJEfuVlmbq++qXLHPwT/l/GtjRuRhWf24qHFyTVRCRdLgJlXBedDoDGZA==",
		
		//异步通知地址
		'notify_url' => "http://dashan.haoniube.com/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArHvcZ5hdVzaCvi30D8jl41x54sDjoWXLaWHTw2h4CWo8JHxEH8j3jrri2cs0fhLJ68VC5XQzXiWvJcME6kMA/NbnmZPmhMIDsPIy0TMVOEqnLz92G+twkbmgAw2eQSOfC0GM+rb2pXQLT027q+6fP3KrW+4BgofWkBtnwcJPHK/kdFBFQfuHPD3manyw6wVxslwFw2pEcUNnUmmH2U/5Gd3E42zrM64w3JvBBdH1nh7d7oBofQd+mMVOXfonq/H7IYDZ/Y1IIjVIpHWk5tuwdHWj3j4U+nafK3S/XMmiHxNLKtL4pjXpxgsjOcF3wRKNFcDJGCqNgFX7SFrxD/jU8wIDAQAB",
		
	
);