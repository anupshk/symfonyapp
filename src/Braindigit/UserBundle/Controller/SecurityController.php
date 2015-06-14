<?php
namespace Braindigit\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    public function loginAction(Request $request)
    {
        $securityAuthChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');
        if($securityAuthChecker->isGranted('ROLE_ADMIN') === true) {
            return new RedirectResponse($router->generate('braindigit_demo_homepage'));
        }
        if($securityAuthChecker->isGranted('ROLE_USER') === true) {
            return new RedirectResponse($router->generate('fos_user_profile_show'));
        }
        return parent::loginAction($request);
    }

    public function renderLogin(array $data)
    {
        $requestAttributes = $this->container->get('request')->attributes;
        if ($requestAttributes->get('_route') == 'braindigit_admin_login') {
            $template = sprintf('BraindigitUserBundle:Backend/Security:login.html.twig');
        } else {
            //$template = sprintf('FOSUserBundle:Security:login.html.twig');
            $template = sprintf('BraindigitUserBundle:Frontend/Security:login.html.twig');
        }
        return $this->container->get('templating')->renderResponse($template, $data);
    }
}