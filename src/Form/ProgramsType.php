<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProgramsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', ChoiceType::class, [
                'label' => 'Année',
                'choices' => [
                    2022 => 2022,
                    2023 => 2023,
                    2024 => 2024,
                    2025 => 2025,
                    2026 => 2026,
                ],
                'attr' => [
                    'class' => 'form-select shadow-none'
                ]
            ])
            ->add('fileSrc', FileType::class, [
                'label' => 'Uploadez un fichier PDF',
                'required' => false, // Changez selon vos besoins
                'constraints' => [
                    new File([
                        'maxSize' => '5120k', // Limite la taille du fichier à 1024 kilo-octets (1 Mo)
                        'mimeTypes' => [
                            'application/pdf', // Accepte uniquement les fichiers de type PDF
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control shadow-none'
                ]
            ])
            ->add('Action', SubmitType::class, [
                'label' => 'Ajoutez',
                'attr' => [
                    'class' => 'mt-2 w-100 btn btn-danger',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
