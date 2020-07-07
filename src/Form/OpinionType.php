<?php

namespace App\Form;

use App\Entity\Opinion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpinionType extends AbstractType
{    
    /**
     * buildForm
     *
     * @param  mixed $builder
     * @param  mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('rating', IntegerType::class, [
                'label'=>'name',
                'attr' => ['min' => 1, 'max' => 5], ])
        ;
    }
    
    /**
     * configureOptions
     *
     * @param  mixed $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opinion::class,
        ]);
    }
}
