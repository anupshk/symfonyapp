<?php
namespace Braindigit\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class UserCreationListener implements EventSubscriberInterface
{
    protected $em;
    protected $user;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        //$roles = array('ROLE_ADMIN');
        $this->user = $event->getForm()->getData();
        $group_name = 'Manager';
        $entity = $this->em->getRepository('BraindigitUserBundle:Group')->findOneByName($group_name);
        //$this->user->setRoles($roles);
        $this->user->addGroup($entity);
        $this->em->flush();
    }
}