<?php

namespace Braindigit\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends FOSRestController
{
    /**
     * Return all users
     * @ApiDoc(
     *  resource=true,
     *  description="Return all users"
     * )
     */
    public function getUsersAction()
    {
        $repository = $this->getDoctrine()->getRepository('BraindigitUserBundle:User');
        $users = $repository->findAllUsers();
        $view = $this->view($users);
        return $this->handleView($view);
    }
}
