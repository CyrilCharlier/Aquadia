<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\Test;
use App\Form\TestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TestController extends AbstractController
{
    #[Route('/aquarium/{id}/test/new', name: 'app_test_new')]
    public function newTest(Request $request, Aquarium $aquarium, EntityManagerInterface $em): Response
    {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cet aquarium.");
        }
        $test = new Test();
        $test->setAquarium($aquarium);

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($test);
            $em->flush();

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId()
            ]);
        }

        return $this->render('test/new.html.twig', [
            'form'      => $form->createView(),
            'aquarium'  => $aquarium,
        ]);
    }

    #[Route('/aquarium/{aquarium}/test/{id}/delete', name: 'app_test_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function deleteTest(
        Request $request,
        Aquarium $aquarium,
        Test $test,
        EntityManagerInterface $em
    ): Response {
        // Vérifie que l'aquarium appartient bien au user connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez pas le droit de supprimer cette analyse.");
        }
        if ($this->isCsrfTokenValid('delete' . $test->getId(), $request->request->get('_token'))) {
            $em->remove($test);
            $em->flush();

            $this->addFlash('success', 'Analyse supprimée avec succès.');
        }

        return $this->redirectToRoute('app_aquarium_show', [
            'id' => $aquarium->getId()
        ]);
    }

    #[Route('/aquarium/{aquarium}/test/{id}/edit', name: 'app_test_edit', methods: ['GET', 'POST'])]
    public function testEdit(
        Request $request,
        Aquarium $aquarium,
        Test $test,
        EntityManagerInterface $em
    ): Response {

        // Sécurité : on s'assure que le test appartient bien à cet aquarium
        if ($test->getAquarium() !== $aquarium) {
            throw $this->createAccessDeniedException("Ce test n'appartient pas à cet aquarium.");
        }

        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Paramètre modifié avec succès.');

            return $this->redirectToRoute('app_aquarium_show', [
                'id' => $aquarium->getId(),
                '_fragment' => 'analyse',
            ]);
        }

        return $this->render('test/edit.html.twig', [
            'aquarium' => $aquarium,
            'test' => $test,
            'form' => $form,
        ]);
    }
}
