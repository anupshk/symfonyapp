<?php
namespace Braindigit\UserBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;

class UserManager extends BaseUserManager
{
    private $defaultOptions = array(
        'sortField' => 'id',
        'sortDirection' => 'DESC'
    );

    public function findAllUsers()
    {
        $orderBy = array($this->defaultOptions['sortField'] => $this->defaultOptions['sortDirection']);
        return $this->repository->findBy(array(), $orderBy);
    }

    public function setDefaultOptions(array $options)
    {
        $this->defaultOptions = array_merge($this->defaultOptions, $options);
    }
}