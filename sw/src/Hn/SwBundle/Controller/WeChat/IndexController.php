<?php

namespace Hn\SwBundle\Controller\WeChat;

use Hn\SwBundle\Controller\WeChat\WxBaseController as TopController;

class IndexController extends TopController
{
    public function indexAction()
    {
        $this->bootstrap();
        return $this->render('HnSwBundle:WeChat/index:index.html.twig');
    }
}
