<?php

namespace Braindigit\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Braindigit\CategoryBundle\Entity\Category;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $food = new Category();
        $food->setTitle('Food');
        $food->setOwnerId(1);
        $food->setBundle('page');
        $food->setStatus(1);
        $food->setCreatedOn(new \DateTime());

        $fruits = new Category();
        $fruits->setOwnerId(1);
        $fruits->setBundle('page');
        $fruits->setStatus(1);
        $fruits->setCreatedOn(new \DateTime());
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);
        $vegetables->setOwnerId(1);
        $vegetables->setBundle('page');
        $vegetables->setStatus(1);
        $vegetables->setCreatedOn(new \DateTime());

        $carrots = new Category();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);
        $carrots->setParent($food);
        $carrots->setOwnerId(1);
        $carrots->setBundle('page');
        $carrots->setStatus(1);
        $carrots->setCreatedOn(new \DateTime());

        $em = $this->getDoctrine()->getManager();

        $em->persist($food);
        $em->persist($fruits);
        $em->persist($vegetables);
        $em->persist($carrots);
        $em->flush();
        return $this->render('BraindigitCategoryBundle:Default:index.html.twig', array('name' => 'done'));
    }
}
