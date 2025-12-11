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
            ->add('name', null, [
                'required' => true,
                'label' => 'aquarium.name',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('volume', null, [
                'label' => 'aquarium.volume',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('wateringDate', null, [
                'widget' => 'single_text',
                'label' => 'aquarium.wateringdate',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('temperature', null, [
                'label' => 'aquarium.temperature',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('description', null, [
                'label' => 'aquarium.description',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'rows' => 3,
                    'class' => 'form-control',
                ],
            ])
            ->add('typeAquarium', FormEnumType::class, [
                'class' => TypeAquarium::class,
                'attr' => [
                    'class' => 'form-select',
                ],
                'choice_label' => fn($choice) => match($choice) {
                    TypeAquarium::EAU_DOUCE => 'type.eaudouce',
                    TypeAquarium::MARIN     => 'type.marin',
                },
                'label' => 'aquarium.type',
                'label_attr' => ['class' => 'form-label text-white-50'],
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '4M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                        mimeTypesMessage: 'Formats acceptés : JPG, PNG ou WEBP.'
                    )
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('phMin', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.phmin',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('phMax', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.phmax',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('ghMin', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.ghmin',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('ghMax', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.ghmax',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('khMin', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.khmin',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('khMax', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.khmax',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('no2', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.no2',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('no3', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.no3',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('nhx', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.nhx',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('conductiviteMax', NumberType::class, [
                'required' => false,
                'label' => 'aquarium.conductivitemax',
                'label_attr' => ['class' => 'form-label text-white-50'],
                'attr' => [
                    'class' => 'form-control',
                ],
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
