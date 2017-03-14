<?php

namespace Hn\SwBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * Doctrine对象
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function em()
    {
        return $this->getDoctrine()->getManager();
    }

    public function getGoodsTypeRepository()
    {
        return $this->em()->getRepository('HnSwBundle:GoodsType');
    }
}
