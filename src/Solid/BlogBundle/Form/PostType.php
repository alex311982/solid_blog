<?php

namespace Solid\BlogBundle\Form;

use Solid\BlogBundle\DBAL\EnumCategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = EnumCategoryType::$staticValues;

        $builder->add('name', 'textarea', array(
                'attr' => array('cols' => '100', 'rows' => '1'),
                'required' => true,
                'invalid_message' => 'You don’t enter the name'
            ));
        $builder->add('intro', 'textarea', array(
                'attr' => array('cols' => '100', 'rows' => '3'),
                'required' => true,
                'invalid_message' => 'You don’t enter the intro'
            ));
        $builder->add('content', 'textarea', array(
                'attr' => array('cols' => '100', 'rows' => '10'),
                'required' => true,
                'invalid_message' => 'You don’t enter the content'
            ));
        $builder->add('category', 'choice', array(
                'choices' => $categories,
                'invalid_message' => 'Choose the category'
            ));
        $builder->add('save', 'submit');
    }

    public function getName()
    {
        return 'new_article';
    }
}