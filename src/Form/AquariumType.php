<?php

namespace App\Form;

use App\Entity\Aquarium;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use App\Enum\TypeAquarium;
use Symfony\Component\Form\Extension\Core\Type\EnumType as FormEnumType;

class AquariumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('volume')
            ->add('wateringDate', null, [
                'widget' => 'single_text',
            ])
            ->add('temperature')
            ->add('description')
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Formats acceptés : JPG, PNG ou WEBP.',
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('phMin', NumberType::class, [
                'required' => false,
                'label' => 'pH min (unités)',
                'attr' => ['placeholder' => 'pH min'],
            ])
            ->add('phMax', NumberType::class, [
                'required' => false,
                'label' => 'pH max (unités)',
                'attr' => ['placeholder' => 'pH max'],
            ])
            ->add('ghMin', NumberType::class, [
                'required' => false,
                'label' => 'GH min (°dGH)',
                'attr' => ['placeholder' => 'GH min'],
            ])
            ->add('ghMax', NumberType::class, [
                'required' => false,
                'label' => 'GH max (°dGH)',
                'attr' => ['placeholder' => 'GH max'],
            ])
            ->add('khMin', NumberType::class, [
                'required' => false,
                'label' => 'KH min (°dKH)',
                'attr' => ['placeholder' => 'KH min'],
            ])
            ->add('khMax', NumberType::class, [
                'required' => false,
                'label' => 'KH max (°dKH)',
                'attr' => ['placeholder' => 'KH max'],
            ])

            ->add('no2', NumberType::class, [
                'required' => false,
                'label' => 'NO₂ max (mg/L)',
                'attr' => ['placeholder' => 'NO2 max'],
            ])
            ->add('no3', NumberType::class, [
                'required' => false,
                'label' => 'NO₃ max (mg/L)',
                'attr' => ['placeholder' => 'NO3 max'],
            ])
            ->add('nhx', NumberType::class, [
                'required' => false,
                'label' => 'NH₃/NH₄ max (mg/L)',
                'attr' => ['placeholder' => 'NH3/NH4 max'],
            ])
            ->add('conductiviteMax', NumberType::class, [
                'required' => false,
                'label' => 'Conductivité max (µS/cm)',
                'attr' => ['placeholder' => 'conductivité'],
            ])
            ->add('typeAquarium', FormEnumType::class, [
                'class' => TypeAquarium::class,
                'choice_label' => fn($choice) => match($choice) {
                    TypeAquarium::EAU_DOUCE => 'Eau douce',
                    TypeAquarium::MARIN     => 'Marin',
                },
                'label' => 'Type d\'aquarium',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Aquarium::class,
        ]);
    }
}
