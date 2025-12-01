<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AquadiaController extends AbstractController
{
    #[Route('/', name: 'app_aquadia')]
    public function index(): Response
    {
        return $this->render('aquadia/index.html.twig');
    }
}
