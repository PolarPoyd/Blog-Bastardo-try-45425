<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()

                ]
            ],
            'second_options' => [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Confirmation du mot de passe',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\NotBlank()
                ]
            ],

            'invalid_message' => 'Les deux mots de passes ne correspondent pas.'
        ])

        ->add('newPassword', PasswordType::class, [
            'attr' =>['class' => 'form-control'],
            'label' => 'Nouveau mot de passe',
            'label_attr' => ['class' => 'form-label- mt-4'],
            'constraints' => [new Assert\NotBlank()]
        ])

        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-outline-primary mt-4'
            ],
            'label' => 'Modifier mot de passe'
        ]);

        
    }
}