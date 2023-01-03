<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' =>'Changez votre pseudo',
                'label_attr' => [
                    'class' => 'form-label mt-3'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])

            
            ->add('plainPassword', PasswordType::class, [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Entrez votre mot de passe',
                    'label_attr' => [
                        'class' => 'form-label mt-3'
                    ],
                    'constraints' => [
                        new Assert\NotNull(),
                        new Assert\NotBlank()
                        ]
                    ],
                
                    )

                    ->add('submit', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn btn-outline-primary mt-4'
                        ],
                    'label' => 'Valider'
                    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
