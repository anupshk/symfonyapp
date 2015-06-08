<?php
namespace Braindigit\PageBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

class Thread extends BaseThread
{
    protected $id;
}