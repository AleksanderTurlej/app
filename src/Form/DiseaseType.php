<?php

namespace App\Form;

use App\Entity\Disease;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiseaseType extends AbstractType
{
    /**
     * buildForm.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                    'name',
                    TextType::class,
                    [
                    'required' => true,
                    'label' => 'label_disease.name',
                    'attr' => ['max_length' => 45],
                    ]
                );
    }

    /**
     * configureOptions.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Disease::class,
        ]);
    }
}
