<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;
use Hn\SwBundle\Form\GoodsTypeAttrForm;
use Hn\SwBundle\Form\GoodsTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Hn\SwBundle\Entity\GoodsType;

class GoodsTypeController extends BaseController
{
    public function indexAction()
    {
        $allData = $this->getGoodsTypeRepository()->findAll();
        return $this->render('HnSwBundle:Backend/type:index.html.twig',array(
            'gtype' => $allData
        ));
    }

    /**
     * 新增一个商品的类型
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $GoodsTypeEntity = new GoodsType();
        $form = $this->createForm(GoodsTypeForm::class,$GoodsTypeEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em();
            $em->persist($GoodsTypeEntity);
            $em->flush();
            return $this->redirectToRoute('backend_goods_type_index');
        }

        return $this->render('HnSwBundle:Backend/type:new.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function propertyAction()
    {
        return $this->render('HnSwBundle:Backend/type:property.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPropertyAction(Request $request)
    {
        $GoodsTypeEntity = new GoodsType();
//        $form = $this->createForm(GoodsTypeAttrForm::class,$GoodsTypeEntity);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->em();
//            $em->persist($GoodsTypeEntity);
//            $em->flush();
//            return $this->redirectToRoute('backend_goods_type_index');
//        }
        return $this->render('HnSwBundle:Backend/type:property-new.html.twig',array(
//            'form' => $form->createView(),
        ));
    }
}
