<?php
// src/Blogger/BlogBundle/Repository/CommentRepository.php

namespace Blogger\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the Comments associated with a specific Blog the displays and   //
    //orders them if they are approved.                                       //
    //------------------------------------------------------------------------//    
    public function getCommentsForBlog($blogId, $approved = true)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->where('c.blog = :blog_id')
                   ->addOrderBy('c.created')
                   ->setParameter('blog_id', $blogId);
        
        if(false === is_null($approved))
            $qb->andWhere('c.approved = :approved')
               ->setParameter('approved', $approved);
        
        return $qb->getQuery()
                  ->getResult();
    }

    //------------------------------------------------------------------------//
    //      Accessor Method                                                   //
    //                                                                        //
    //Returns the last 10 comments within the comment table.                  //
    //------------------------------------------------------------------------//
    public function getLatestComments($limit = 10, $approved = true)
    {
        $qb = $this->createQueryBuilder('c')
                   ->select('c')
                   ->addOrderBy('c.id', 'DESC');
        
        if(false === is_null($limit))
            $qb->setMaxResults($limit)
               ->andWhere('c.approved = :approved')
               ->setParameter('approved', $approved);
        
        return $qb->getQuery()
                  ->getResult();
    }
}