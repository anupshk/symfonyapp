<?php
namespace Braindigit\UserBundle\EventListener;

use Braindigit\UserBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CacheImageListener
{
    protected $cacheManager;
    private $filter = 'userprofile_thumb';

    public function __construct($cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User) {
            $this->cacheManager->remove($entity->getOldProfilePicture(), $this->filter);
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User) {
            $this->cacheManager->remove($entity->getWebProfilePicture(), $this->filter);
        }
    }
}