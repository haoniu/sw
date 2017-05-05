<?php

namespace Hn\SwBundle\Controller\Backend;

use Entity\Category;
use Hn\SwBundle\Entity\GoodsCategory;
use Hn\SwBundle\Form\GoodsCategorySonType;
use Hn\SwBundle\Form\GoodsCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Hn\SwBundle\Controller\BaseController;

/**
 * 商品分类控制器
 * author：Sam-大山
 * createTime：2017年3月23日
 * updateTime：2017年5月5日17:14:20
 * Class GoodsCategoryController
 * @package Hn\SwBundle\Controller\Backend
 */
class GoodsCategoryController extends BaseController
{

    /**
     * 分类首页
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $arrCate = $this->getGoodsCategoryRepository()->childrenHierarchy();
        //$this->p($arrCate);
        return $this->render('HnSwBundle:Backend/category:index.html.twig',array(
            'arrCate' => $arrCate
        ));
    }

    /**
     * 新建一个分类
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $GoodsCategoryEntity = new GoodsCategory();
        $form = $this->createForm(GoodsCategoryType::class,$GoodsCategoryEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em();
            $em->persist($GoodsCategoryEntity);
            $em->flush();
            return $this->redirectToRoute('backend_goods_category_index');
        }

        return $this->render('HnSwBundle:Backend/category:new.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * 新建一个子分类
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newSonCateAction(Request $request)
    {
        $pid = $request->get('pid');
        $GoodsCategoryEntity = new GoodsCategory();
        $form = $this->createForm(GoodsCategorySonType::class,$GoodsCategoryEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em();
            $fatherCate = $this->getGoodsCategoryRepository()->find($pid);
            $GoodsCategoryEntity->setParent($fatherCate);
            $em->persist($GoodsCategoryEntity);
            $em->flush();
            return $this->redirectToRoute('backend_goods_category_index');
        }

        return $this->render('HnSwBundle:Backend/category:new-son-cate.html.twig',array(
            'form' => $form->createView(),
            'pid' => $pid,
        ));
    }
}
