<?php
// src/Blogger/BlogBundle/Entity/Blog.php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\BlogRepository")
 * @ORM\Table(name="blog") 
 * @ORM\HasLifecycleCallbacks()
 */
class Blog
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
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $author;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $blog;
    
    /**
     * @ORM\Column(type="string", length="20")
     */
    protected $image;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $tags;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    /**
     * @ORM\Column(type="string") 
     */
    protected $slug;
    
    //------------------------------------------------------------------------//
    //      Constructor Method                                                //
    //                                                                        //
    //Initalizes a new created and updated timestamp.                         //
    //------------------------------------------------------------------------//    
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Updates the timestamp for when the blog post is updated.                //
    //------------------------------------------------------------------------//
    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
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
    //Returns the title.                                                      //
    //------------------------------------------------------------------------//
    public function getTitle()
    {
        return $this->title;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the title.                                                         //
    //------------------------------------------------------------------------//  
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($this->title);
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the author.                                                     //
    //------------------------------------------------------------------------//
    public function getAuthor()
    {
        return $this->author;
    }
 
    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the author.                                                        //
    //------------------------------------------------------------------------// 
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the blog text.                                                  //
    //------------------------------------------------------------------------//
    public function getBlog($length = null)
    {
        if(false == is_null($length) && $length > 0)
            return substr($this->blog, 0, $length);
        else
            return $this->blog;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the blog post text.                                                //
    //------------------------------------------------------------------------// 
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the image filename.                                             //
    //------------------------------------------------------------------------//
    public function getImage()
    {
        return $this->image;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the image filename.                                                //
    //------------------------------------------------------------------------// 
    public function setImage($image)
    {
        $this->image = $image;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the tag names of the blog post.                                 //
    //------------------------------------------------------------------------//
    public function getTags()
    {
        return $this->tags;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the tags.                                                          //
    //------------------------------------------------------------------------//     
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the comments array for each blog post.                          //
    //------------------------------------------------------------------------//
    public function getComments()
    {
        return $this->comments;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the blog post comments array.                                      //
    //------------------------------------------------------------------------//     
    public function setComments($comments)
    {
        $this->comments = $comments;
    }
    
    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Adds a comment to the comments array.                                   //
    //------------------------------------------------------------------------//     
    public function addComments(Comment $comment)
    {
        $this->comments[] = $comment;
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
    
    //------------------------------------------------------------------------//
    //      __toString Method                                                 //
    //                                                                        //
    //Sets the timestamp for when the blog is updated.                        //
    //------------------------------------------------------------------------//         
    public function __toString()
    {
        return $this->getTitle();
    }
 
    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the slug value used for assigning the URL routing.              //
    //------------------------------------------------------------------------//    
    public function getSlug()
    {
        return $this->slug;
    }

    //------------------------------------------------------------------------//
    //      Mutator Method                                                    //
    //                                                                        //
    //Sets the slug value to be slugified.                                    //
    //------------------------------------------------------------------------//    
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    //------------------------------------------------------------------------//
    //      Helper Method                                                     //
    //                                                                        //
    //Generates the URL text to be used for the slug value in the routing.yml //
    //file.                                                                   //
    //------------------------------------------------------------------------//     
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        
        // trim
        $text = trim($text, '-');
        
        // transliterate
        if(function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        
        // lowercase
        $text = strtolower($text);
        
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
        
        if(empty($text))
        {
            return 'n-a';
        }
        
        return $text;
    }

    //------------------------------------------------------------------------//
    //      Helper Method                                                     //
    //                                                                        //
    //Validates the blog post form to make sure user enters in information for//
    //all the fields required.                                                //
    //------------------------------------------------------------------------//      
    public static function loadValidorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('author', new NotBlank(array('message' => 'You must enter your name')));
        $metadata->addPropertyConstraint('title', new NotBlank(array('message' => 'You must enter a title')));
        $metadata->addPropertyConstraint('blog', new NotBlank(array('message' => 'You must enter some text')));
        $metadata->addPropertyConstraint('image', new NotBlank(array('message' => 'You must enter a filename')));
        $metadata->addPropertyConstraint('tags', new NotBlank(array('message' => 'You must enter a tag')));
    }
}
?>
