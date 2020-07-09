<?php

namespace App\Form;

use App\Entity\Opinion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpinionType extends AbstractType
{
    /**
     * buildForm
     *
     * @param  FormBuilderInterface $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                TextareaType::class,
                [
                    'required' => true,
                    'label' => 'label.opinion_content',
                ]
            )
            ->add(
                'rating',
                IntegerType::class,
                [
                    'required' => true,
                    'label' => 'lable_opinion.rating',
                    'attr' => ['min' => 1, 'max' => 5],
                ]
            )
        ;
    }

    /**
     * configureOptions
     *
     * @param  OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opinion::class,
        ]);
    }
}
