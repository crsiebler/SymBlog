<?php
// src/Blogger/BlogBundle/Entity/Comment.php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks() 
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string") 
     */
    protected $user;
    
    /**
     * @ORM\Column(type="text") 
     */
    protected $comment;
    
    /**
     * @ORM\Column(type="boolean") 
     */
    protected $approved;
    
    /**
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id") 
     */
    protected $blog;
    
    /**
     * @ORM\Column(type="datetime") 
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime") 
     */
    protected $updated;

    //------------------------------------------------------------------------//
    //      Constructor Method                                                //
    //                                                                        //
    //Initializes a new comment entity with the timestamps auto generated.    //
    //------------------------------------------------------------------------//     
    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        
        $this->setApproved(true);
    }
    
    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Updates the timestamp for when the comment is updated.                  //
    //------------------------------------------------------------------------//
    /**
     * @ORM\preUpdate 
     */
    public function setupdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }
    
    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the Table id.                                                   //
    //------------------------------------------------------------------------// 
    public function getId()
    {
        return $this->id;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the user.                                                      //
    //------------------------------------------------------------------------//
    public function getUser()
    {
        return $this->user;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the user.                                                         //
    //------------------------------------------------------------------------// 
    public function setUser($user)
    {
        $this->user = $user;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the comment data.                                               //
    //------------------------------------------------------------------------//
    public function getComment()
    {
        return $this->comment;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the comment data.                                                  //
    //------------------------------------------------------------------------//     
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns whether the comment is approved or not.                         //
    //------------------------------------------------------------------------//
    public function getApproved()
    {
        return $this->approved;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets whether the comment is approved or not.                            //
    //------------------------------------------------------------------------//     
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the blog value associated with the comment entity.              //
    //------------------------------------------------------------------------//
    public function getBlog()
    {
        return $this->blog;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Initializes the blog table the comment entity should reference.         //
    //------------------------------------------------------------------------//
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the timestamp for when the blog was created.                    //
    //------------------------------------------------------------------------//
    public function getCreated()
    {
        return $this->created;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the timestamp for when the blog is created.                        //
    //------------------------------------------------------------------------// 
    public function setCreated($created)
    {
        $this->created = $created;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the timestamp for when the blog was updated.                    //
    //------------------------------------------------------------------------//
    public function getUpdated()
    {
        return $this->updated;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the timestamp for when the blog is updated.                        //
    //------------------------------------------------------------------------// 
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    
    public static function loadValidorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('user', new NotBlank(array('message' => 'You must enter your name')));
        $metadata->addPropertyConstraint('comment', new NotBlank(array('message' => 'You must enter a comment')));
    }
}