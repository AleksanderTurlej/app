<?php

namespace App\Form;

use App\Entity\Favourites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavouritesType extends AbstractType
{
    
    /**
     * configureOptions
     *
     * @param  mixed $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Favourites::class,
        ]);
    }
}
