<?php

namespace Hn\SwBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Hn\SwBundle\Document\Product;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HnSwBundle:Default:index.html.twig');
    }

    public function createAction()
    {
        $product = new Product();
        $product->setName('A Foo Bar2');
        $product->setPrice('29.99');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        return new Response('Created product id '.$product->getId());
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
