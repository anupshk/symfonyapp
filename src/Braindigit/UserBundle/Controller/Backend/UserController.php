<?php
namespace Braindigit\UserBundle\Controller\Backend;

use Braindigit\CommonBundle\Controller\CommonController;
use Braindigit\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Image;

class UserController extends CommonController
{
    public function indexAction(Request $request)
    {
        $filtering = $this->getFiltering($request);
        $search = $filtering['search'];

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
                'field' => $filtering['sort_field'],
                'order' => $filtering['sort_direction']
            ]
        ];
        $limit = null;
        $offset = null;
        $repository = $this->getDoctrine()->getRepository('BraindigitUserBundle:User');
        $usersQB = $repository->findAllUsersQB($criteria, $orderings);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $usersQB->getQuery(),
            $filtering['page'],
            $filtering['rpp'],
            array(
                'defaultSortFieldName' => $orderings[0]['field'],
                'defaultSortDirection' => $orderings[0]['order'],
                'sortFieldWhitelist' => $repository->getSortableFields()
            )
        );
        return $this->render('BraindigitUserBundle:Backend/User:index.html.twig', array(
            'pagination' => $pagination,
            'list_data' => $filtering,
            'rpp' => $filtering['rpp'],
            'search' => $search
        ));
    }

    public function formAction(Request $request, $id)
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $profile_picture = '';
        $emptyPassword = false;

        if(empty($id)) {
            $user = $userManager->createUser();
            $user->setEnabled(true);
        } else {
            $user = $this->getDoctrine()->getRepository('BraindigitUserBundle:User')->find($id);
            if(!$user) {
                throw $this->createNotFoundException('User with ID '.$id.' does not exists!');
            }
            $profile_picture = $user->getWebProfilePicture();
            //if form has been submitted
            if($request->getMethod() === 'POST') {
                //if no password is entered
                $formData = $request->request->get('fos_user_registration_form');
                if(strlen($formData['plainPassword']['first']) === 0 && strlen($formData['plainPassword']['second']) === 0) {
                    $dummyPass = 'dummy';
                    $postData = $request->request->all();
                    $postData['fos_user_registration_form']['plainPassword']['first'] = $dummyPass;
                    $postData['fos_user_registration_form']['plainPassword']['second'] = $dummyPass;
                    $request->request->replace($postData);
                    $emptyPassword = true;
                }
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
        $form->add('profile_picture_file', 'file', array(
            'label' => 'Profile picture',
            'required' => false,
            'constraints' => array(
                new Image(
                    array(
                        'maxSize' => '1M',
                        /*'minWidth' => '200',
                        'maxWidth' => '400',
                        'minHeight' => '200',
                        'maxHeight' => '400',
                        'allowLandscape' => false,
                        'allowPortrait' => false*/
                    )
                )
            )
        ));
        if($id > 0) {
            $form->add('change_password', 'checkbox', array(
                'required' => false,
                'mapped' => false,
            ));
            if(!empty($profile_picture)) {
                $form->add('remove_profile_picture', 'checkbox', array(
                    'required' => false,
                ));
            }
        }
        $form->setData($user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($emptyPassword) {
                $user->setPlainPassword('');
            }
            $user->setRoles($form->getData()->getRoles());
            $userManager->updateUser($user);
            $this->addFlash('success', 'User "'.$user->getUsername().'" saved!');
            if($request->request->has('save_close')) {
                return $this->redirectToRoute('braindigit_user_list');
            } else {
                return $this->redirectToRoute('braindigit_user_form', array('id' => $user->getId()));
            }
        }
        return $this->render('BraindigitUserBundle:Backend/User:form.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'profile_picture' => $profile_picture,
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

    public function deleteAction(Request $request)
    {
        $params = $request->query->all();
        $id = $request->request->getInt('id');
        if($id == $this->getUser()->getId()) {
            $this->addFlash('error', 'Cannot delete self!');
            return $this->redirectToRoute('braindigit_user_list', $params);
        }
        if($id > 0) {
            $user = $this->getDoctrine()->getRepository('BraindigitUserBundle:User')->find($id);
            if(!$user) {
                throw $this->createNotFoundException('User with ID '.$id.' does not exists!');
            }
            $deleted_user = $user->getUsername();
            $userManager = $this->get('fos_user.user_manager');
            $userManager->deleteUser($user);
            $this->addFlash('success', 'User "'.$deleted_user.'" deleted!');
            return $this->redirectToRoute('braindigit_user_list', $params);
        }
        $this->addFlash('error', 'Error deleting user with id '.$id);
        return $this->redirectToRoute('braindigit_user_list', $params);
    }
}