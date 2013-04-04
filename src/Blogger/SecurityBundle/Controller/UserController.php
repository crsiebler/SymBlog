<?php
// src/Blogger/BlogBundle/Controller/Controller/UserController.php;
namespace Blogger\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Blogger\SecurityBundle\Entity\User;
use Blogger\SecurityBundle\Form\UserType;

class UserController extends Controller
{
    public function registerAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();
        
        $user = new User();        
        
        $form = $this->createForm(new UserType(), $user);
        
	if($request->getMethod() == 'POST')
	{
	    $form->bindRequest($request);

	    if($form->isValid())
	    {
                if(!$em->getRepository('BloggerSecurityBundle:User')->findByUsername($user->getUsername()) && $user->getUsername() != 'cory')
                {
                    if(!$em->getRepository('BloggerSecurityBundle:User')->findByEmail($user->getEmail()))
                    {
                        $em->persist($user);

                        $user->getUserRoles()->add($em->getRepository('BloggerSecurityBundle:Role')->findOneByRole('ROLE_USER'));
                        $factory = $this->get('security.encoder_factory');
                        $encoder = $factory->getEncoder($user);
                        $password = $user->getPassword();
                        $password = $encoder->encodePassword($password, $user->getSalt());
                        $user->setPassword($password);

                        $em->flush();

                        $this->get('session')->setFlash('blogger-notice', 'Your user has been added successfully.');

                        return $this->redirect($request->headers->get('referer'));
                    }
                    else
                    {
                        $this->get('session')->setFlash('blogger-notice', 'Your email is already in our database.');
                        return $this->render('BloggerSecurityBundle:User:register.html.twig', array('form' => $form->createView()));                        
                    }
                }
                else
                {
                    $this->get('session')->setFlash('blogger-notice', 'Your username is already taken.');
                    return $this->render('BloggerSecurityBundle:User:register.html.twig', array('form' => $form->createView()));
                }
            }
        }

        return $this->render('BloggerSecurityBundle:User:register.html.twig', array('form' => $form->createView()));
    }
    
    public function editAction()
    {
        $token = $this->get('security.context')->getToken();
        $user = $token->getUser();
        
        $em = $this->getDoctrine()->getEntityManager();
        $request = $this->getRequest();

        $form = $this->createForm(new UserType(), $user);
         
        if($request->getMethod() == "POST")
        {
            $form->bindRequest($request);

            if($form->isValid())
            {
                $em->merge($user);
                $em->flush();

                $this->get('session')->setFlash('blogger-notice', 'Your user has successfully been updated.');

                return $this->redirect($request->headers->get('referer'));
            }
        }

        return $this->render('BloggerSecurityBundle:User:edit.html.twig', array('form' => $form->createView()));
    }
}
?>
