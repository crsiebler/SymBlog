<?php
// src/Blogger/BlogBundle/Controller/AdminController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
	$em = $this->getDoctrine()
                   ->getEntityManager();
        
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
                    ->getLatestBlogs();
        
        return $this->render('BloggerBlogBundle:Page:index.html.twig', array('blogs' => $blogs));
    }
    
    public function sidebarAction()
    {
        return $this->render('BloggerBlogBundle:Admin:sidebar.html.twig');
    }
}
?>
