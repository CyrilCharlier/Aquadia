<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Form\AquariumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AquariumController extends AbstractController
{
    #[Route('/aquarium/new', name: 'app_aquarium_new', methods: ['POST', 'GET'])]
    public function new(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $aquarium = new Aquarium();
        $form = $this->createForm(AquariumType::class, $aquarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                // Déplacement du fichier dans /public/uploads/aquariums
                $imageFile->move(
                    $this->getParameter('aquariums_directory'),
                    $newFilename
                );

                // Sauvegarde du nom de l’image en DB
                $aquarium->setImage($newFilename);
            }
            $aquarium->setUser($this->getUser());
            $em->persist($aquarium);
            $em->flush();
        }

        return $this->redirectToRoute('app_aquadia');
    }

    #[Route('/aquarium/{id}/edit', name: 'app_aquarium_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Aquarium $aquarium,
        EntityManagerInterface $em
    ): Response {

        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cet aquarium.');
        }

        $form = $this->createForm(AquariumType::class, $aquarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($aquarium);
            $em->flush();

            $this->addFlash('success', 'Aquarium modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
            ]);
        }

        return $this->render('aquarium/edit.html.twig', [
            'aquarium' => $aquarium,
            'form' => $form,
        ]);
    }

    #[Route('/aquarium/{id}', name: 'app_aquarium_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Aquarium $aquarium): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès à cet aquarium.');
        }
        return $this->render('aquarium/show.html.twig', [
            'aquarium' => $aquarium
        ]);
    }

    #[Route('/aquarium/{id}', name: 'app_aquarium_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet aquarium.");
        }
        if ($this->isCsrfTokenValid('delete' . $aquarium->getId(), $request->request->get('_token'))) {
            $em->remove($aquarium);
            $em->flush();

            $this->addFlash('success', 'Aquarium supprimé avec succès.');
        }

        return $this->redirectToRoute('app_aquadia');
    }
}
