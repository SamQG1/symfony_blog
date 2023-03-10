<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class, [
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Saisissez le nom du produit',
                ],
                'label'=>'Nom du produit'

            ])
            ->add('price',NumberType::class, [
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Saisissez le prix du produit',
                ],
                'label'=>'Prix du produit'

            ])
            ->add('description',TextareaType::class, [
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Décrivez le produit',
                ],
                'label'=>'Description'

            ])
             ->add('picture',FileType::class, [
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Ajoutez une photo du produit',
                ],
                'label'=>'Image du produit',
                'constraints'=>[
                    new File([
                        'mimeTypes'=>[
                            "image/png",
                            "image/jpg",
                            "image/jpeg",
                            "image/webp",
                            "image/gif"
                        ],
                        'mimeTypesMessage'=>"Extensions autorisées : png, jpg, jpeg,webp, gif"
                    ])
                ]

            ])
            ->add('Enregistrer',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
