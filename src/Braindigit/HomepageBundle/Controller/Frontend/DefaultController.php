<?php

namespace Braindigit\HomepageBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BraindigitHomepageBundle:Frontend/Default:index.html.twig');
    }
}
