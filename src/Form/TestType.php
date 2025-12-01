<?php

namespace App\Form;

use App\Entity\Test;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date du test',
                'data' => new \DateTime(),
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('ph', null, [
                'label' => 'pH',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('gh', null, [
                'label' => 'GH (°dGH)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('kh', null, [
                'label' => 'KH (°dKH)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('no2', null, [
                'label' => 'NO₂ (mg/L)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('no3', null, [
                'label' => 'NO₃ (mg/L)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('nhx', null, [
                'label' => 'NH₃/NH₄ (mg/L)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('conductivite', null, [
                'label' => 'Conductivité (µS/cm)',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('comment', null, [
                'label' => 'Commentaire',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
