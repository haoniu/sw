<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;

class IndexController extends BaseController
{
    public function indexAction()
    {
        return $this->render('HnSwBundle:Backend/index:index.html.twig');
    }
}
