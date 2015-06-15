<?php
namespace Braindigit\UserBundle\Controller\Backend;

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
        return $this->render('BraindigitUserBundle:Backend/User:index.html.twig', array(
            'pagination' => $pagination,
            'list_data' => $list_data,
            'rpp' => $rpp,
            'search' => $search
        ));
    }

    public function formAction(Request $request, $id)
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');

        if(empty($id)) {
            $user = $userManager->createUser();
            $user->setEnabled(true);
        } else {
            $user = $this->getDoctrine()->getRepository('BraindigitUserBundle:User')->find($id);
            if(!$user) {
                throw $this->createNotFoundException('User with ID '.$id.' does not exists!');
            }
        }

        $form = $formFactory->createForm();
        $roles = $this->getAllRoles();
        $form->add('roles', 'choice', array(
            'choices' => $roles,
            'data' => $user->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
            'required' => false,
        ));
        $form->add('groups', 'entity', array(
            'label' => 'Groups',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
            'required' => false,
            'class' => 'Braindigit\UserBundle\Entity\Group',
            'property' => 'name',
            'data' => $user->getGroups(),
        ));
        $form->add('profile_picture_file','file');
        $form->setData($user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($form->getData()->getRoles());
            $userManager->updateUser($user);
            $this->addFlash('success', 'User "'.$user->getUsername().'" saved!');
            return $this->redirectToRoute('braindigit_user_list');
        }
        return $this->render('BraindigitUserBundle:Backend/User:form.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
        ));
    }

    private function getAllRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);
        $allRoles = [];
        foreach($roles as $role) {
            $allRoles[$role] = $role;
        }
        return $allRoles;
    }
}