<?php

namespace PublicBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrowseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tag',TextType::class, array('required' => false))
            ->add('user', TextType::class, array('required' => false))
            ->add('created',  ChoiceType::class, array(
                'choices'  => array(
                    'Last Month' => 'month',
                    'Last Year' => 'year',
                    'Anytime' => 'always',
                ),
            ))
            ->add('browse', SubmitType::class)
        ;
    }
    public function getName()
    {
        return 'browse_form';
    }
}