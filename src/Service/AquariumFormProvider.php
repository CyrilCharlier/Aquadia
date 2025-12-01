<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use App\Form\AquariumType;
use App\Entity\Aquarium;

class AquariumFormProvider
{
    public function __construct(
        private FormFactoryInterface $formFactory
    ) {}

    public function getForm()
    {
        $aquarium = new Aquarium();

        return $this->formFactory->create(AquariumType::class, $aquarium);
    }
}
