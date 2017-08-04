<?php

namespace Hn\SwBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Hn\SwBundle\Document\Product;
use Hn\SwBundle\Form\ProductType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $manager = $this->get('oneup_acl.manager');
        $k = $manager->isGranted('ROLE_ADMIN');
        //dump($k);exit();
        return $this->render('HnSwBundle:Default:index.html.twig');
    }

    public function createAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();
            return $this->redirectToRoute('hn_sw_proshow');
        }

        return $this->render('HnSwBundle:Default:basic-info.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function showAction()
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('HnSwBundle:Product')
            ->findAll();

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ');
        }

        // do something, like pass the $product object into a template
        return $this->render('HnSwBundle:Default:product.html.twig',array(
            'data' => $product
        ));
    }
}
