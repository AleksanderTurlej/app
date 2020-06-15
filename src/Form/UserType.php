<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

class UserType extends AbstractType
{
    public const CONFIRM_PASSWORD_OPTION = 'confirm_password';
    public const REGISTER_OPTION = 'register_option';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nick')
//            ->add('email')
//            ->add('roles')
//            ->add('password')
        ;

        if(true === $options[self::REGISTER_OPTION]){
            $builder
                ->add('email');

        }

        if(true === $options[self::REGISTER_OPTION] || true === $options[self::CONFIRM_PASSWORD_OPTION]){
            $builder
                ->add('password')

            ;
        }

        if(true === $options[self::CONFIRM_PASSWORD_OPTION]) {
            $builder
                ->add(self::CONFIRM_PASSWORD_OPTION)
            ;

        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            self::CONFIRM_PASSWORD_OPTION => false,
            self::REGISTER_OPTION => false,
            'allow_extra_fields' => true,

        ]);
    }
}
