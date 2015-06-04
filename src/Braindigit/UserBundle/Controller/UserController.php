<?php
namespace Braindigit\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        /*$userManager = $this->container->get('fos_user.user_manager');
        $userManager->setDefaultOptions(array(
            'sortField' => $request->query->getAlpha($this->container->getParameter('query_param_sort'), 'id'),
            'sortDirection' => $request->query->getAlpha($this->container->getParameter('query_param_direction'), 'DESC'),
        ));
        $users = $userManager->findAllUsers();*/

        $criteria = [];
        /*$criteria = [
            [
                'field' => 'fullname',
                'operator' => 'contains',
                'value' => 'min'
            ]
        ];*/
        /*$orderings = [
            ['field' => 'fullname', 'order' => 'ASC'],
            ['field' => 'id', 'order' => 'DESC'],
        ];*/
        $orderings = [
            [
                'field' => $request->query->getAlpha($this->container->getParameter('query_param_sort'), 'id'),
                'order' => $request->query->getAlpha($this->container->getParameter('query_param_direction'), 'DESC')
            ]
        ];
        $limit = null;
        $offset = null;
        $users = $this->getDoctrine()->getRepository('BraindigitUserBundle:User')->findAllUsers($criteria, $orderings, $limit, $offset);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            $request->query->getInt('rpp', 10)
        );
        return $this->render('BraindigitUserBundle:User:index.html.twig', array('pagination' => $pagination));
    }
}