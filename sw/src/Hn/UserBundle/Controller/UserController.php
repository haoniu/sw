<?php

namespace Hn\UserBundle\Controller;

use Hn\UserBundle\Entity\User;
use Hn\UserBundle\Entity\BackendUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Hn\UserBundle\Form\UserType;
use Hn\UserBundle\Form\BackendUserType;

class UserController extends Controller
{
    public function registerAction(Request $request, $type = 0 )
    {
        if ( $type ) {
            $user = new BackendUser();
            $form = $this->createForm(BackendUserType::class, $user);
        }else{
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
        }


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('hn_sw_homepage');
        }

        return $this->render('HnUserBundle:user:register.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one / 获取可能存在的登录错误信息
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user / 获取用户输入的username（用户名）
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'HnUserBundle:user:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    public function logoutAction()
    {

    }

}
