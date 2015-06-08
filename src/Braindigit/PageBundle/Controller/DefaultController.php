<?php

namespace Braindigit\PageBundle\Controller;

use Braindigit\PageBundle\Form\Type\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Braindigit\PageBundle\Entity\Page;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BraindigitPageBundle:Default:index.html.twig', array('name' => $name));
    }

    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $page = new Page();
        //$page->setTitle('Page created @ '.time());
        //$page->setContent('Lorem ipsum dolor');
        $page->setCreatedOn(new \DateTime('now'));
        $page->setPublishedOn(new \DateTime('now'));
        $page->setOwnerId($this->getUser()->getId());
        $page->setStatus(1);
        $page->setTags('');

        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('braindigit_page_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return new Response("Page created");
            //return $this->redirectToRoute('braindigit_page_new');
        }

        return $this->render('BraindigitPageBundle:Default:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function testcommentAction(Request $request)
    {
        $id = 'page_1';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);

        return $this->render('BraindigitPageBundle:Default:testcomment.html.twig', array(
            'comments' => $comments,
            'thread' => $thread,
        ));
    }
}
