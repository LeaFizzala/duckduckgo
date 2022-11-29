<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price' )
            ->add('status', ChoiceType::class,
            [
                'choices' => [
                    'Very bad' => Annonce::STATUS_VERY_BAD,
                    'Bad' => Annonce::STATUS_BAD,
                    'Good' =>  Annonce::STATUS_GOOD,
                    'Very Good' =>  Annonce::STATUS_VERY_GOOD,
                    'Perfect' =>  Annonce::STATUS_PERFECT,
                ]
            ])
            ->add('createdAt', DateType::class)
            ->add('sold')
            ->add('imageUrl')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
            'translation_domain' => 'forms'
            // ici on peut passer toutes les options qu'on veut

        ]);
    }
}
