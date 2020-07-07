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
            ->add('name', TextType::class, ['label'=>'name', 'attr' => ['placeholder' => 'enter medicine',
            ], ], )
            ->add('price', NumberType::class, ['label'=>'price'])
            ->add('weight', NumberType::class, ['label'=>'weight'])
            ->add('isRecipeRequired', CheckboxType::class, ['label'=>'isRecipeRequired', 'required' => false])
            ->add('diseases', EntityType::class, ['label'=>'disease', 'class' => Disease::class, 'choice_label' => 'name', 'multiple' => true])
            ->add(
                'substances',
                EntityType::class,
                [
                    'label'=>'substances',
                    'class' => Substance::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                ]
            );
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
            'data_class' => Medicine::class,
        ]);
    }
}
