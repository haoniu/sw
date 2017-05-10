<?php

namespace Hn\SwBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function aliPayAction(Request $request)
    {

        if($request->getMethod() == 'POST')
        {
            $this->get('ali_pay')->pay();
        }

        return $this->render('HnSwBundle:Default:alipay.html.twig');
    }
}
