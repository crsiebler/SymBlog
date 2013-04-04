<?php
// src/Blogger/blogBundle/Controller/CommentController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Comment;
use Blogger\BlogBundle\Form\CommentType;

/**
 * Comment controller. 
 */
class CommentController extends Controller
{
    public function newAction($blog_id)
    {
        $token = $this->get('security.context')->getToken();
        $user = $token->getUsername();
        
        $blog = $this->getBlog($blog_id);
        
        $comment = new Comment();
        $comment->setBlog($blog);
        
        if($this->get('security.context')->isGranted('ROLE_ADMIN') || $this->get('security.context')->isGranted('ROLE_USER'))
            $comment->setUser($user);
        
        $form = $this->createForm(new CommentType(), $comment);
        
        return $this->render('BloggerBlogBundle:Comment:form.html.twig', array('comment' => $comment, 'form' => $form->createView()));
    }
    
    public function createAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);
        
        $comment = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form = $this->createForm(new CommentType(), $comment);
        $form->bindRequest($request);
        
        if($form->isValid())
        {
            $em = $this->getDoctrine()
                       ->getEntityManager();
            $em->persist($comment);
            $em->flush();
            
            return $this->redirect($request->headers->get('referer') . '#comment-' . $comment->getId());
        }
        
        return $this->render('BloggerBlogBundle:Comment:create.html.twig', array('comment' => $comment, 'form' => $form->createView()));
    }
    
    public function removeAction($id)
    {
        $comment = $this->getComment($id);
        $comment->setApproved(false);
        
        $request = $this->getRequest();
        
        $em = $this->getDoctrine()
                   ->getEntityManager();
        $em->persist($comment);
        $em->flush();        
        
        return $this->redirect($request->headers->get('referer') . '#comments');
    }
    
    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blog_id);
        
        if(!$blog)
            throw $this->createNotFoundException('Unable to find Blog post.');
        
        return $blog;
    }
    
    protected function getComment($comment_id)
    {
        $em = $this->getDoctrine()
                   ->getEntityManager();
        
        $comment = $em->getRepository('BloggerBlogBundle:Comment')->find($comment_id);
        
        if(!$comment)
            throw $this->createNotFoundException('Unable to find Comment.');
        
        return $comment;
    }
}
?>
