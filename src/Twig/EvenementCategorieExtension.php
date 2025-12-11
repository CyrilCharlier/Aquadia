<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use App\Service\EvenementCategorieFormProvider;

class EvenementCategorieExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private EvenementCategorieFormProvider $provider
    ) {}

    public function getGlobals(): array
    {
        return [
            'evenement_categorie_form' => $this->provider->getForm()->createView()
        ];
    }
}
