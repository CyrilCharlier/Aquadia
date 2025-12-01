<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\Poisson;
use App\Form\PoissonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PoissonController extends AbstractController
{
    #[Route('/aquarium/{id}/poisson/new', name: 'app_poisson_new')]
    public function newPoisson(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet aquarium.");
        }
        $poisson = new Poisson();
        $poisson->setAquarium($aquarium);

        $form = $this->createForm(PoissonType::class, $poisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($poisson);
            $em->flush();

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId()
            ]);
        }

        return $this->render('poisson/new.html.twig', [
            'form'      => $form->createView(),
            'aquarium'  => $aquarium,
        ]);
    }

    #[Route('/aquarium/{aquarium}/poisson/{id}/delete', name: 'app_poisson_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteTest(
        Request $request,
        Aquarium $aquarium,
        Poisson $poisson,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }
        if ($this->isCsrfTokenValid('delete' . $poisson->getId(), $request->request->get('_token'))) {
            $em->remove($poisson);
            $em->flush();

            $this->addFlash('success', 'Poisson supprimé avec succès.');
        }

        return $this->redirectToRoute('app_aquarium_show', [
            'id' => $aquarium->getId()
        ]);
    }

    #[Route('/aquarium/{aquarium}/poisson/{id}/edit', name: 'app_poisson_edit', methods: ['GET', 'POST'])]
    public function testEdit(
        Request $request,
        Aquarium $aquarium,
        Poisson $poisson,
        EntityManagerInterface $em
    ): Response {

        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }

        $form = $this->createForm(PoissonType::class, $poisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($poisson);
            $em->flush();

            $this->addFlash('success', 'Poisson modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
            ]);
        }

        return $this->render('poisson/edit.html.twig', [
            'aquarium' => $aquarium,
            'poisson' => $poisson,
            'form' => $form,
        ]);
    }
}
