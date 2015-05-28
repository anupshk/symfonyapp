<?php
namespace Braindigit\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            2
        );
        return $this->render('BraindigitUserBundle:User:index.html.twig', array('pagination' => $pagination));
    }
}