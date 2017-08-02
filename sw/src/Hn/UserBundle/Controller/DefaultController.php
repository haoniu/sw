<?php

namespace Hn\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HnUserBundle:Default:index.html.twig');
    }
}
