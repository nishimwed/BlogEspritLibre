<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('image', FileType::class, [
                'label' => 'Article Image (JPEG or PNG file)',
                'mapped' => false,  // Ce champ n'est pas associé directement à l'entité
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG or PNG)',
                    ])
                ],
            ])
            ->add('content',null, [ 'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'content'
            ])
            ->add('created_at', null, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('category', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Category::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
