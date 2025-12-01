<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Service\AquariumFormProvider;

class AquariumExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private AquariumFormProvider $provider
    ) {}

    public function getGlobals(): array
    {
        return [
            'aquarium_form' => $this->provider->getForm()->createView()
        ];
    }
}
