<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public const CONFIRM_PASSWORD_OPTION = 'confirm_password';
    public const REGISTER_OPTION = 'register_option';

    /**
     * buildForm.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nick',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'label_user.name',
                ]
                )
        ;

        if (true === $options[self::REGISTER_OPTION]) {
            $builder
                ->add(
                    'email',
                    TextType::class,
                    [
                        'required' => true,
                        'label' => 'label_user.email',
                    ]
                    );
        }

        if (true === $options[self::REGISTER_OPTION]) {
            $builder
                ->add(
                    'password',
                    TextType::class,
                    [
                        'required' => true,
                        'label' => 'label_user.password',
                    ]
                    )
            ;
        }
        if (true === $options[self::CONFIRM_PASSWORD_OPTION]) {
            $builder
                ->add(
                    'password',
                    TextType::class,
                    [
                        'label' => 'password',
                        'required' => false,
                    ]
                    );
        }

        if (true === $options[self::CONFIRM_PASSWORD_OPTION]) {
            $builder
                ->add(self::CONFIRM_PASSWORD_OPTION, TextType::class, ['required' => true])
                ->add(
                    'roles',
                    CheckboxType::class,
                    [
                        'label' => 'is_admin',
                        'required' => false,
                    ]
                    );

            $builder
            ->get(
                'roles'
                )
            ->addModelTransformer(
                new CallbackTransformer(
                    function (array $roles) {
                        return in_array(User::ROLE_ADMIN, $roles);
                    },
                    function (bool $isAdmin) {
                        return $isAdmin ? [User::ROLE_ADMIN] : [User::ROLE_USER];
                    }
                )
            )
            ;
        }
    }

    /**
     * configureOptions.
     *
     * @param configureOptions $resolver
     */
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
