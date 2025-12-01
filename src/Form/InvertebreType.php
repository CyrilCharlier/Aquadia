<?php

namespace App\Form;

use App\Entity\Invertebre;
use App\Entity\EspeceInvertebre;
use App\Repository\EspeceInvertebreRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvertebreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('dateAjout', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'ajout',
                'data' => new \DateTime(),
                'attr' => ['class' => 'form-control'],
            ])

            ->add('comment', null, [
                'label' => 'Commentaire',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('espece', EntityType::class, [
                'class' => EspeceInvertebre::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une espèce',
                'required' => true,
                'label' => 'Espèce de l\'invertebre',

                'query_builder' => function (EspeceInvertebreRepository $r) {
                    return $r->createQueryBuilder('e')
                        ->andWhere('e.enable = :enabled')
                        ->setParameter('enabled', true)
                        ->orderBy('e.name', 'ASC');
                },

                'attr' => ['class' => 'form-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invertebre::class,
        ]);
    }
}
