<?php

namespace Braindigit\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BraindigitDemoBundle:Default:index.html.twig', array('name' => $name));
    }
}
