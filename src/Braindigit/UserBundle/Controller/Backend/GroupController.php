<?php
namespace Braindigit\UserBundle\Controller\Backend;

use Braindigit\CommonBundle\Controller\CommonController;
use Braindigit\UserBundle\Entity\Group;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends CommonController
{
    public function indexAction(Request $request)
    {
        $filtering = $this->getFiltering($request);
        $search = $filtering['search'];

        $criteria = [];
        if(mb_strlen($search) > 0) {
            $criteria['or'] = [
                [
                    'field' => 'name',
                    'operator' => 'contains',
                    'value' => $search
                ]
            ];
        }
        $orderings = [
            [
                'field' => $filtering['sort_field'],
                'order' => $filtering['sort_direction']
            ]
        ];
        $limit = null;
        $offset = null;
        $repository = $this->getDoctrine()->getRepository('BraindigitUserBundle:Group');
        $groups = $repository->findAllGroups($criteria, $orderings, $limit, $offset);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $groups,
            $filtering['page'],
            $filtering['rpp'],
            array(
                'defaultSortFieldName' => $orderings[0]['field'],
                'defaultSortDirection' => $orderings[0]['order'],
                'sortFieldWhitelist' => ['id', 'name']
            )
        );
        return $this->render('BraindigitUserBundle:Backend/Group:index.html.twig', array(
            'pagination' => $pagination,
            'list_data' => $filtering,
            'rpp' => $filtering['rpp'],
            'search' => $search
        ));
    }

    public function formAction(Request $request, $id)
    {
        $formFactory = $this->get('fos_user.group.form.factory');
        $groupMananger = $this->get('fos_user.group_manager');

        if(empty($id)) {
            $group = $groupMananger->createGroup('');
        } else {
            $group = $this->getDoctrine()->getRepository('BraindigitUserBundle:Group')->find($id);
        }
        $form = $formFactory->createForm();
        $roles = $this->getAllRoles();
        $form->add('roles', 'choice', array(
            'choices' => $roles,
            'data' => $group->getRoles(),
            'label' => 'Roles',
            'expanded' => true,
            'multiple' => true,
            'mapped' => true,
            'required' => false,
        ));
        $form->setData($group);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $group->setRoles($form->getData()->getRoles());
            $groupMananger->updateGroup($group);
            $this->addFlash('success', 'Group "'.$group->getName().'" saved!');
            if($request->request->has('save_close')) {
                return $this->redirectToRoute('braindigit_group_list');
            } else {
                return $this->redirectToRoute('braindigit_group_form', array('id' => $group->getId()));
            }
        }
        return $this->render('BraindigitUserBundle:Backend/Group:form.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
        ));
    }

    public function deleteAction(Request $request)
    {
        $params = $request->query->all();
        $id = $request->request->getInt('id');
        if($id > 0) {
            $group = $this->getDoctrine()->getRepository('BraindigitUserBundle:Group')->find($id);
            if(!$group) {
                throw $this->createNotFoundException('Group with ID '.$id.' does not exists!');
            }
            $deleted_group = $group->getName();
            $groupManager = $this->get('fos_user.group_manager');
            $groupManager->deleteGroup($group);
            $this->addFlash('success', 'Group "'.$deleted_group.'" deleted!');
            return $this->redirectToRoute('braindigit_group_list', $params);
        }
        $this->addFlash('error', 'Error deleting group with id '.$id);
        return $this->redirectToRoute('braindigit_group_list', $params);
    }
}