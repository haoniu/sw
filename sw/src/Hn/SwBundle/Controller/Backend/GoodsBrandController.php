<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;

class GoodsBrandController extends BaseController
{
    public function indexAction()
    {
        return $this->render('HnSwBundle:Backend/brand:index.html.twig');
    }

    public function newAction()
    {
        return $this->render('HnSwBundle:Backend/brand:new.html.twig');
    }
}
