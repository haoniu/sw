<?php

namespace Hn\SwBundle\Controller\Backend;

use Hn\SwBundle\Controller\BaseController;
use Hn\SwBundle\Entity\GoodsAttrValue;
use Hn\SwBundle\Entity\GoodsTypeAttr;
use Hn\SwBundle\Form\GoodsTypeAttrForm;
use Hn\SwBundle\Form\GoodsTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Hn\SwBundle\Entity\GoodsType;

class GoodsTypeController extends BaseController
{
    public function indexAction(Request $request)
    {
        $allData = $this->getGoodsTypeRepository()->findAll();
//        $serializer = $this->get('jms_serializer');
//        $data = $serializer->serialize($allData, 'json');
//        dump($data);exit();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $allData, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('HnSwBundle:Backend/type:index.html.twig',array(
            'gtype' => $pagination,
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


    public function editAction(GoodsType $goodsType)
    {

    }

    public function propertyAction(Request $request)
    {
        $tid = $request->get('tid');
        $typeAttrData = $this->getGoodsTypeAttrRepository()->getTidAttr($tid);

        return $this->render('HnSwBundle:Backend/type:property.html.twig',array(
            'tid' => $tid,
            'typeAttr' =>$typeAttrData
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPropertyAction(Request $request)
    {
        $GoodsTypeAttrEntity = new GoodsTypeAttr();
        $tid = $request->get('tid');
        $form = $this->createForm(GoodsTypeAttrForm::class,$GoodsTypeAttrEntity);
        $form->handleRequest($request);
        //$this->p($tid);
        if ($form->isSubmitted() && $form->isValid()) {
            $attrValue = $request->get('attrValue');
            $GoodsTypeAttrEntity->setTid($tid);
            $GoodsTypeAttrEntity->setValue(implode(',',$attrValue));
            $em = $this->em();
            $em->persist($GoodsTypeAttrEntity);
            $em->flush();
            foreach ($attrValue as $k=>$v){
                $GoodsAttrValueEntity = new GoodsAttrValue();
                $GoodsAttrValueEntity->setValue($v);
                $GoodsAttrValueEntity->setTaid($GoodsTypeAttrEntity->getId());
                $em->persist($GoodsAttrValueEntity);
            }
            $em->flush();
            return $this->redirectToRoute('backend_goods_type_property',array('tid' => $tid));
        }
        return $this->render('HnSwBundle:Backend/type:property-new.html.twig',array(
            'form' => $form->createView(),
            'tid' => $tid
        ));
    }
}
