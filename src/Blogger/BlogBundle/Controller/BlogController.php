<?php 
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Form\BlogType;
use Blogger\BlogBundle\Form\CommentType;

/**
 * Blog controller. 
 */
class BlogController extends Controller
{
    /**
     * Show a blog entry 
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if(!$blog)
            throw $this->createNotFoundException('Unable to find Blog post.');
        
        $comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentsForBlog($blog->getId());
        
        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array('blog' => $blog, 'comments' => $comments));
    }
    
    /**
     * Update a blog entry
     */
    public function updateAction($id)
    {
        $token = $this->get('security.context')->getToken();
        $user = $token->getUsername();
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $this->getBlog($id);
        
        $comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentsForBlog($blog->getId());
        
        $request = $this->getRequest();
        
        if($user === $blog->getAuthor() || $this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $form = $this->createForm(new BlogType(), $blog);

            if($request->getMethod() == "POST")
            {
                $form->bindRequest($request);

                if($form->isValid())
                {
                    $em->persist($blog);
                    $em->flush();

                    $this->get('session')->setFlash('blogger-notice', 'The current post was successfully updated.');

                    return $this->redirect($request->headers->get('referer'));
                }
            }

            return $this->render('BloggerBlogBundle:Blog:update.html.twig', array('blog' => $blog, 'comments' => $comments, 'form' => $form->createView()));
        }
        else
        {
            $this->get('session')->setFlash('blogger-notice', 'You must be an admin or the author to edit this post');
            return $this->redirect($request->headers->get('referer'));
        }
    }
    
    /**
     * Add a blog entry
     */
    public function addAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = new Blog();
        
        $request = $this->getRequest();
        $form = $this->createForm(new BlogType(), $blog);
        
        if($request->getMethod() == "POST")
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $user = $this->get('security.context')->getToken()->getUsername();
                $blog->setAuthor($user);
                
                $em->persist($blog);
                $em->flush();
                
                $this->get('session')->setFlash('blogger-notice', 'Your post has been added successfully.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('BloggerBlogBundle:Blog:add.html.twig', array('blog' => $blog, 'form' => $form->createView()));
    }    
    
    protected function getBlog($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if(!$blog)
            throw $this->createNotFoundException('Unable to find Blog post.');
    
        return $blog;
    }    
}
?>
