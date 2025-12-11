<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\EvenementCategorie;
use App\Repository\EvenementCategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];

        $builder
            ->add('description', null, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
            ])

            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'data' => new \DateTime(),
                'attr' => ['class' => 'form-control'],
            ])

            ->add('categorie', EntityType::class, [
                'class' => EvenementCategorie::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir une catégorie',
                'required' => true,
                'label' => 'Catégorie',

                'query_builder' => function (EvenementCategorieRepository $r) use ($user)  {
                    return $r->createQueryBuilder('e')
                        ->andWhere('e.enable = :enabled')
                        ->andWhere('e.user = :user')
                        ->setParameter('enabled', true)
                        ->setParameter('user', $user)
                        ->orderBy('e.name', 'ASC');
                },

                'attr' => ['class' => 'form-select'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'user' => null,
        ]);
    }
}
