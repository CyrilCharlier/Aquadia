<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use App\Form\EvenementCategorieType;
use App\Entity\Aquarium;
use App\Entity\EvenementCategorie;

class EvenementCategorieFormProvider
{
    public function __construct(
        private FormFactoryInterface $formFactory
    ) {}

    public function getForm()
    {
        $evtCategorie = new EvenementCategorie();

        return $this->formFactory->create(EvenementCategorieType::class, $evtCategorie);
    }
}
