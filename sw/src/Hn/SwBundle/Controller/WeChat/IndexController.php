<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\WeChat\WxBaseController as TopController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends TopController
{
    public function indexAction()
    {
        $this->bootstrap();
        echo $this->access_token;
        return $this->render('HnSwBundle:WeChat/index:index.html.twig');
    }

    public function checkAction()
    {
        $this->valid();

        return new Response();
    }
}
