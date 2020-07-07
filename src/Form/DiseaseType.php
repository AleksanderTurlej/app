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
     * buildForm
     *
     * @param  mixed $builder
     * @param  mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'name'])
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
            'data_class' => Disease::class,
        ]);
    }
}
