<?php
// src/Blogger/SecurityBundle/Form/UserType.php

namespace Blogger\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('username')
                ->add('email', 'email')
                ->add('password', 'repeated', array(
                      'first_name' => 'password',
                      'second_name' => 'confirm',
                      'type' => 'password'));
    }

    public function getName()
    {
        return 'user';
    }
}
?>
