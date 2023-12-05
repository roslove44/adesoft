<?php

namespace App\Form;

use App\Entity\Trainings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingsType extends AbstractType
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');
        if ($currentRoute === 'app_admin_trainings_edit') {
            $action = "Mettre à jour";
        } else {
            $action = "Ajoutez";
        }
        $builder
            ->add('name', TextType::class, [
                'label' => 'Intitulé de la formation*',
                'label_attr' => ['class' => 'mt-2'],
                'attr' => [
                    'class' => 'form-control shadow-none',
                ],
            ])
            ->add('pass', IntegerType::class, [
                'label' => 'Coût de la formation*',
                'label_attr' => ['class' => 'mt-2'],
                'attr' => [
                    'class' => 'form-control shadow-none',
                ],
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu de la formation*',
                'label_attr' => ['class' => 'mt-2'],
                'attr' => [
                    'class' => 'form-control shadow-none',
                ],
            ])
            ->add('start_at', DateType::class, [
                'label' => 'Date de début*',
                'label_attr' => ['class' => 'mt-2'],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control shadow-none',
                ],
                'input'  => 'datetime_immutable',
            ])
            ->add('end_at', DateType::class, [
                'label' => 'Date de fin',
                'label_attr' => ['class' => 'mt-2'],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control shadow-none',
                ],
                'input'  => 'datetime_immutable',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'mt-2'],
                'attr' => [
                    'class' => 'form-control shadow-none',
                    'rows' => 5,
                ],
                'required' => false,
            ])
            ->add('Action', SubmitType::class, [
                'label' => $action,
                'attr' => [
                    'class' => 'mt-2 w-100 btn btn-danger',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trainings::class,
        ]);
    }
}
