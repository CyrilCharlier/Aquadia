<?php

namespace App\Form;

use App\Entity\Poisson;
use App\Entity\EspecePoisson;
use App\Enum\Genre;
use App\Repository\EspecePoissonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class PoissonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('genre', EnumType::class, [
                'class' => Genre::class,
                'label' => 'Genre',
                'choice_label' => fn (Genre $choice) => match ($choice) {
                    Genre::FEMELLE      => 'Femelle',
                    Genre::MALE         => 'Mâle',
                    Genre::INDETERMINE  => 'Indéterminé',
                },
                'attr' => ['class' => 'form-control'],
            ])

            ->add('dateAcquisition', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'acquisition',
                'data' => new \DateTime(),
                'attr' => ['class' => 'form-control'],
            ])

            ->add('comment', null, [
                'label' => 'Commentaire',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('espece', EntityType::class, [
                'class' => EspecePoisson::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une espèce',
                'required' => true,
                'label' => 'Espèce de poisson',

                'query_builder' => function (EspecePoissonRepository $r) {
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
            'data_class' => Poisson::class,
        ]);
    }
}
