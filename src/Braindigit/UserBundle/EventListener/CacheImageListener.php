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
            $img = $entity->getOldProfilePicture();
            if(!empty($img)) {
                $this->cacheManager->remove($img, $this->filter);
            }
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof User) {
            $img = $entity->getAbsoluteProfilePicture();
            if(file_exists($img) && is_file($img)) {
                $this->cacheManager->remove($entity->getWebProfilePicture(), $this->filter);
            }
        }
    }
}