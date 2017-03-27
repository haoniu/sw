<?php

namespace Hn\SwBundle\Controller\Backend;

use Entity\Category;
use Hn\SwBundle\Entity\GoodsCategory;
use Hn\SwBundle\Form\GoodsCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Hn\SwBundle\Controller\BaseController;

class GoodsCategoryController extends BaseController
{
    public function indexAction()
    {
        $arrCate = $this->getGoodsCategoryRepository()->childrenHierarchy();
//        $this->p($arrCate);
        return $this->render('HnSwBundle:Backend/category:index.html.twig',array(
            'arrCate' => $arrCate
        ));
    }

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

    public function newSonCateAction(Request $request)
    {
        $pid = $request->get('pid');
        $GoodsCategoryEntity = new GoodsCategory();
        $form = $this->createForm(GoodsCategoryType::class,$GoodsCategoryEntity);
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
            'pid' => $pid
        ));
    }
}
