<?php

namespace App\Form;

use App\Entity\Disease;
use App\Entity\Medicine;
use App\Entity\Substance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => ['placeholder' => 'enter medicine',
            ], ])
            ->add('price', NumberType::class)
            ->add('weight', NumberType::class)
            ->add('isRecipeRequired', CheckboxType::class, ['required' => false])
            ->add('diseases', EntityType::class, ['class' => Disease::class, 'choice_label' => 'name', 'multiple' => true])
            ->add(
                'substances',
                EntityType::class,
                [
                    'class' => Substance::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medicine::class,
        ]);
    }
}
