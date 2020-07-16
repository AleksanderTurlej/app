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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


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
                    'label' => 'label_medicine.name',
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
                    'label' => 'label_medicine.price'
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                [
                    'required' => true,
                    'label' => 'label_medicine.weight'
                ]
            )
            ->add(
                'isRecipeRequired',
                CheckboxType::class,
                [
                    'required' => false,
                    'label' => 'label_medicine.isRecipeRequired',
                ]
            )
            ->add(
                'diseases',
                EntityType::class,
                [
                    'required' => true,
                    'label' => 'label_medicine.disease',
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
                    'label' => 'label_medicine.substances',
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
            ->add('brochure', FileType::class, [
                'label' => 'Brochure (Jpg file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the jpg file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/pjpeg',
                            'image/jpeg',
                            'image/pjpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid jgp document',
                    ])
                ]
            ]);
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
