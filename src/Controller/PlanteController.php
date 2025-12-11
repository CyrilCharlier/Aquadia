<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\Plante;
use App\Form\PlanteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlanteController extends AbstractController
{
    #[Route('/aquarium/{id}/plante/new', name: 'app_plante_new')]
    public function new(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet aquarium.");
        }
        $plante = new Plante();
        $plante->setAquarium($aquarium);

        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($plante);
            $em->flush();

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId()
            ]);
        }

        return $this->render('plante/new.html.twig', [
            'form'      => $form->createView(),
            'aquarium'  => $aquarium,
        ]);
    }

    #[Route('/aquarium/{aquarium}/plante/{id}/delete', name: 'app_plante_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteTest(
        Request $request,
        Aquarium $aquarium,
        Plante $plante,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }
        if ($this->isCsrfTokenValid('delete' . $plante->getId(), $request->request->get('_token'))) {
            $em->remove($plante);
            $em->flush();

            $this->addFlash('success', 'Plante supprimée avec succès.');
        }

        return $this->redirectToRoute('app_aquarium_show', [
            'id' => $aquarium->getId()
        ]);
    }

    #[Route('/aquarium/{aquarium}/plante/{id}/edit', name: 'app_plante_edit', methods: ['GET', 'POST'])]
    public function testEdit(
        Request $request,
        Aquarium $aquarium,
        Plante $plante,
        EntityManagerInterface $em
    ): Response {

        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }

        $form = $this->createForm(PlanteType::class, $plante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($plante);
            $em->flush();

            $this->addFlash('success', 'Plante modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
            ]);
        }

        return $this->render('plante/edit.html.twig', [
            'aquarium' => $aquarium,
            'plante' => $plante,
            'form' => $form,
        ]);
    }
}
