<?php

namespace App\Form;

use App\Entity\Disease;
use App\Entity\Medicine;
use App\Entity\Substance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicineType extends AbstractType
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
                'name', 
                TextType::class, 
                [
                    'required' => true,
                    'label'=>'label_medicine.name', 
                    'attr' => 
                    [
                        'placeholder' => 'enter medicine',
                    ], 
                ], 
                )
            ->add(
                'price', 
                NumberType::class, 
                [
                    'required' => true,
                    'label'=>'label_medicine.price'
                ]
                )
            ->add(
                'weight', 
                NumberType::class, 
                [
                    'required' => true,
                    'label'=>'label_medicine.weight'
                ]
                )
            ->add(
                'isRecipeRequired', 
                CheckboxType::class, 
                [
                    'required' => true,
                    'label'=>'label_medicine.isRecipeRequired', 
                ]
                )
            ->add(
                'diseases', 
                EntityType::class, 
                [
                    'required' => true,
                    'label'=>'label_medicine.disease', 
                    'class' => Disease::class, 
                    'choice_label' => 'name', 
                    'multiple' => true
                ]
                )
            ->add(
                'substances',
                EntityType::class,
                [
                    'required' => true,
                    'label'=>'label_medicine.substances',
                    'class' => Substance::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                ]
                )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'label_description.name',
                ]
            )
        ;
    }
    
    /**
     * configureOptions
     *
     * @param  OptionsResolvered $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medicine::class,
        ]);
    }
}
