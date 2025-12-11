<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\Evenement;
use App\Entity\EvenementCategorie;
use App\Entity\Invertebre;
use App\Form\EvenementCategorieType;
use App\Form\EvenementType;
use App\Form\InvertebreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EvenementController extends AbstractController
{
    #[Route('/aquarium/{id}/evenement/new', name: 'app_evenement_new')]
    public function new(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit d'accéder à cet aquarium.");
        }
        $evenement = new Evenement();
        $evenement->setAquarium($aquarium);

        $form = $this->createForm(EvenementType::class, $evenement, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId()
            ]);
        }

        return $this->render('evenement/new.html.twig', [
            'form'      => $form->createView(),
            'aquarium'  => $aquarium,
        ]);
    }

    #[Route('/aquarium/{aquarium}/evenement/{id}/delete', name: 'app_evenement_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Request $request,
        Aquarium $aquarium,
        Evenement $evenement,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet evenement.");
        }
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $em->remove($evenement);
            $em->flush();

            $this->addFlash('success', 'Evenement supprimé avec succès.');
        }

        return $this->redirectToRoute('app_aquarium_show', [
            'id' => $aquarium->getId()
        ]);
    }

    #[Route(path:'/aquarium/{aquarium}/evenement/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Aquarium $aquarium,
        Evenement $evenement,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet evenement.");
        }

        $form = $this->createForm(EvenementType::class, $evenement, ['user' => $this->getUser()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evenement);
            $em->flush();

            $this->addFlash('success', 'Evenement modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
            ]);
        }

        return $this->render('evenement/edit.html.twig', [
            'aquarium' => $aquarium,
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/evenement/categorie/new', name: 'app_evenement_categorie_new')]
    public function newCategorie(Request $request, EntityManagerInterface $em): Response
    {
        $evtCategorie = new EvenementCategorie();
        $evtCategorie->setUser($this->getUser());

        $form = $this->createForm(EvenementCategorieType::class, $evtCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evtCategorie);
            $em->flush();

            return $this->redirectToRoute('app_aquadia');
        }

        return $this->render('evenement/new.categorie.html.twig', [
            'form'      => $form->createView(),
        ]);
    }

    #[Route('/evenement/categorie/{id}/edit', name: 'app_evenement_categorie_edit', methods: ['GET', 'POST'])]
    public function editCategorie(
        Request $request,
        EvenementCategorie $evtCategorie,
        EntityManagerInterface $em
    ): Response {
        if ($evtCategorie->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de motifier cet objet.");
        }

        $form = $this->createForm(EvenementCategorieType::class, $evtCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evtCategorie);
            $em->flush();

            $this->addFlash('success', 'Evenement modifié avec succès.');

            return $this->redirectToRoute('app_aquadia');
        }

        return $this->render('evenement/edit.categorie.html.twig', [
            'evenement' => $evtCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/evenement/categorie/{id}/delete', name: 'app_evenement_categorie_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteCategorie(
        Request $request,
        EvenementCategorie $evtCategorie,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($evtCategorie->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet objet.");
        }
        if ($this->isCsrfTokenValid('delete' . $evtCategorie->getId(), $request->request->get('_token'))) {
            $em->remove($evtCategorie);
            $em->flush();

            $this->addFlash('success', 'Evenement supprimé avec succès.');
        }

        return $this->redirectToRoute('app_aquadia');
    }

    #[Route('/evenement/categorie', name: 'app_evenement_categorie_list', methods: ['GET'])]
    public function listCategorie(
        Request $request,
    ): Response {
        return $this->render('evenement/list.categorie.html.twig');
    }
}
