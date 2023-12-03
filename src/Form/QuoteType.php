<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Nom',
                ]
            ])
            ->add('tel', TelType::class, [
                'attr' => [
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Téléphone',
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Adresse Mail',
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'placeholder' => 'Sélectionnez un Objet',
                'choices' => [
                    "Demande de devis" => "Demande de devis",
                    "Renseignement" => "Renseignement",
                    "Réservation" => "Réservation",
                ],
                'attr' => [
                    'class' => 'form-select shadow-none',
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control shadow-none',
                    'placeholder' => 'Message',
                    "rows" => "5",
                    "cols" => "5",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => true,
        ]);
    }
}
