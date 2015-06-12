<?php
namespace Braindigit\UserBundle\Controller;

use Braindigit\UserBundle\Entity\User;
use Braindigit\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $list_data = [];
        $list_data['sort_field'] = 'id';
        $list_data['sort_direction'] = 'ASC';
        $list_data['rpp'] = 10;

        $rpp = $request->query->get('rpp', $list_data['rpp']);
        $search = $request->query->get('search','');

        $criteria = [];
        if(mb_strlen($search) > 0) {
            $criteria['or'] = [
                [
                    'field' => 'fullname',
                    'operator' => 'contains',
                    'value' => $search
                ],
                [
                    'field' => 'username',
                    'operator' => 'contains',
                    'value' => $search
                ],
                [
                    'field' => 'email',
                    'operator' => 'contains',
                    'value' => $search
                ]
            ];
            /*$criteria['and'] = [
                [
                    'field' => 'enabled',
                    'operator' => 'eq',
                    'value' => 1
                ],
                [
                    'field' => 'locked',
                    'operator' => 'eq',
                    'value' => 0
                ]
            ];*/
        }
        $orderings = [
            [
                'field' => $request->query->getAlpha($this->container->getParameter('query_param_sort'), 'id'),
                'order' => $request->query->getAlpha($this->container->getParameter('query_param_direction'), 'desc')
            ]
        ];
        $limit = null;
        $offset = null;
        $repository = $this->getDoctrine()->getRepository('BraindigitUserBundle:User');
        $usersQB = $repository->findAllUsersQB($criteria, $orderings);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $usersQB->getQuery(),
            $request->query->getInt('page', 1),
            $request->query->getInt('rpp', $rpp),
            array(
                'defaultSortFieldName' => $orderings[0]['field'],
                'defaultSortDirection' => $orderings[0]['order'],
                'sortFieldWhitelist' => $repository->getSortableFields()
            )
        );
        return $this->render('BraindigitUserBundle:User:index.html.twig', array(
            'pagination' => $pagination,
            'list_data' => $list_data,
            'rpp' => $rpp,
            'search' => $search
        ));
    }

    public function formAction(Request $request)
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $formFactory->createForm();
        $form->setData($user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $userManager->updateUser($user);
            $this->addFlash('success', 'User "'.$user->getUsername().'" saved!');
            return $this->redirectToRoute('braindigit_user_list');
        }
        return $this->render('BraindigitUserBundle:User:form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}