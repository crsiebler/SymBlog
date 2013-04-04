<?php
// src/Blogger/SecurityBundle/Entity/User.php

namespace Blogger\SecurityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
 * Blogger\SecurityBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="Blogger\SecurityBundle\Repository\UserRepository") 
 * @ORM\Table(name="user")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32)
     * @Assert\NotBlank()
     */
    private $salt;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     * @ORM\ManyToMany(targetEntity="Role")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();   
        $this->isActive = true;
        $this->salt = md5(uniqid('blog', true));
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    } 
  
    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function getEmail()
    {
        return $this->email;
    }
 
    /**
     * @inheritDoc
     */
    public function getUserRoles()
    {
        return $this->roles;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        
    }

    /**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }    
}
?>
