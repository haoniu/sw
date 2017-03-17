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

    /**
     * 打印普通的数组
     * @param $data
     */
    public function p($data)
    {
        echo '<pre>';
        dump($data);
        echo '</pre>';
        exit();
    }

    public function getGoodsTypeRepository()
    {
        return $this->em()->getRepository('HnSwBundle:GoodsType');
    }

    public function getGoodsTypeAttrRepository()
    {
        return $this->em()->getRepository('HnSwBundle:GoodsTypeAttr');
    }

    public function getGoodsAttrValueRepository()
    {
        return $this->em()->getRepository('HnSwBundle:GoodsAttrValue');
    }

    public function getGoodsCategoryRepository()
    {
        return $this->em()->getRepository('HnSwBundle:GoodsCategory');
    }
}
