<?php

namespace Hn\SwBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GoodsController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
