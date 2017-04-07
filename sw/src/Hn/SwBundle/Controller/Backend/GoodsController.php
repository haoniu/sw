<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;

class GoodsController extends BaseController
{
    public function indexAction()
    {
        return $this->render('HnSwBundle:Backend/goods:new.html.twig');
    }

    public function newAction()
    {
        return $this->render('HnSwBundle:Backend/goods:new.html.twig');
    }
}
