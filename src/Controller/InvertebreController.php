<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\Invertebre;
use App\Form\InvertebreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class InvertebreController extends AbstractController
{
    #[Route('/aquarium/{id}/invertebre/new', name: 'app_invertebre_new')]
    public function new(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet aquarium.");
        }
        $invertebre = new Invertebre();
        $invertebre->setAquarium($aquarium);

        $form = $this->createForm(InvertebreType::class, $invertebre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($invertebre);
            $em->flush();

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId()
            ]);
        }

        return $this->render('invertebre/new.html.twig', [
            'form'      => $form->createView(),
            'aquarium'  => $aquarium,
        ]);
    }

    #[Route('/aquarium/{aquarium}/invertebre/{id}/delete', name: 'app_invertebre_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Request $request,
        Aquarium $aquarium,
        Invertebre $invertebre,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }
        if ($this->isCsrfTokenValid('delete' . $invertebre->getId(), $request->request->get('_token'))) {
            $em->remove($invertebre);
            $em->flush();

            $this->addFlash('success', 'Invertebre supprimée avec succès.');
        }

        return $this->redirectToRoute('app_aquarium_show', [
            'id' => $aquarium->getId()
        ]);
    }

    #[Route('/aquarium/{aquarium}/invertebre/{id}/edit', name: 'app_invertebre_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Aquarium $aquarium,
        Invertebre $invertebre,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }

        $form = $this->createForm(InvertebreType::class, $invertebre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($invertebre);
            $em->flush();

            $this->addFlash('success', 'Invertebre modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
            ]);
        }

        return $this->render('invertebre/edit.html.twig', [
            'aquarium' => $aquarium,
            'invertebre' => $invertebre,
            'form' => $form,
        ]);
    }
}
