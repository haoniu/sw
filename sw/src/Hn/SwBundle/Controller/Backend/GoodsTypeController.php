<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;

class GoodsTypeController extends BaseController
{
    public function indexAction()
    {
        return $this->render('HnSwBundle:Backend/type:index.html.twig');
    }

    public function newAction()
    {
        return $this->render('HnSwBundle:Backend/type:new.html.twig');
    }

}
