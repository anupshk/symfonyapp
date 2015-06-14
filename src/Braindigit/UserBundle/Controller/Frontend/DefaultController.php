<?php

namespace Braindigit\UserBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BraindigitUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
