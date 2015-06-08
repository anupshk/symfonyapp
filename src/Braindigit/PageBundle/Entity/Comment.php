<?php
namespace Braindigit\PageBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;

class Comment extends BaseComment
{
    protected $id;
    protected $thread;
}