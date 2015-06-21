<?php
namespace Braindigit\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommonController extends Controller
{
    protected function getFiltering(Request $request)
    {
        $controller = md5($request->attributes->get('_controller'));
        $session = $request->getSession();
        $session_data = $session->get($controller, []);
        $data = [
            'sort_field' => $request->query->getAlpha(
                $this->container->getParameter('query_param_sort'),
                isset($session_data['sort_field'])?$session_data['sort_field']:'id'
            ),
            'sort_direction' => $request->query->getAlpha(
                $this->container->getParameter('query_param_direction'),
                isset($session_data['sort_direction'])?$session_data['sort_direction']:'desc'
            ),
            'rpp' => $request->query->getInt(
                'rpp',
                isset($session_data['rpp'])?$session_data['rpp']:10
            ),
            'page' => $request->query->getInt(
                'page',
                isset($session_data['page'])?$session_data['page']:1
            ),
            'search' => $request->query->get(
                'search',
                isset($session_data['search'])?$session_data['search']:''
            )
        ];
        $session->set($controller, $data);

        return $data;
    }

    protected function getAllRoles()
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