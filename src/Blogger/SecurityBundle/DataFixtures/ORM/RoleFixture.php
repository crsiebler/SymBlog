<?php
// src/Blogger/SecurityBundle/DataFixtures/ORM/RoleFixture.php

namespace Blogger\SecurityBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blogger\SecurityBundle\Entity\Role;

class RoleFixture extends AbstractFixture implements OrderedFixtureInterface
{    
    public function getOrder()
    {
        return 1;
    }
    
    public function load(ObjectManager $manager)
    {
        $role1 = new Role();
        $role1->setRole('ROLE_USER');
        $role1->setName('User');
        $manager->persist($role1);
        
        $role2 = new Role();
        $role2->setRole('ROLE_ADMIN');
        $role2->setName('Admin');
        $manager->persist($role2);
        
        $manager->flush();
    }
}
?>
