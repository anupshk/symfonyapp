<?php

namespace Braindigit\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $name = "Anonymous user";
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $name = "Admin user : ".$this->getUser()->getFullname();
        } else if($this->get('security.context')->isGranted('ROLE_USER')) {
            $name = "Registered user : ".$this->getUser()->getFullname();
        }
        //die("timezone ".date_default_timezone_get());
        return $this->render('BraindigitDemoBundle:Default:index.html.twig', array('name' => $name));
    }
}
