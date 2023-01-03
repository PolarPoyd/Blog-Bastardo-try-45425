<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Categories::class,
                'query_builder' => function (CategoriesRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'label' => 'Les catégories',
                'label_attr' => [
                    'class' =>'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
                ])

            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de l\'article',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            // ->add('created_at') généré auto donc commenté ok
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Description de l\'article',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            // ->add('updated_at') généré auto donc commenté ok
            ->add('submit', SubmitType::class ,[
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer mon article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }


    // public function __toString()
    // {
    //     return $this->categories;
    // }
}
