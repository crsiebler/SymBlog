<?php
// src/Blogger/BlogBundle/Form/BlogType.php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title')
                ->add('blog')
                ->add('image')
                ->add('tags');
    }
  
    public function getName()
    {
        return 'blogger_blogbundle_blogtype';
    }
}
?>
