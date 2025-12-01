<?php

namespace App\Twig;

use Faker\Factory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LoremExtension extends AbstractExtension
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('lorem', [$this->faker, 'paragraphs']),
        ];
    }
}
