<?php

namespace App\Controller;

use App\Entity\Aquarium;
use App\Entity\User;
use App\Form\AquariumType;
use App\Ui\Color\UserEventColors;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AquariumController extends AbstractController
{
    private function getUserApp(): User
    {
        return $this->getUser();
    }

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

        $limits = [
            'ph' => ['min' => $aquarium->getPhMin(), 'max' => $aquarium->getPhMax()],
            'gh' => ['min' => $aquarium->getGhMin(), 'max' => $aquarium->getGhMax()],
            'kh' => ['min' => $aquarium->getKhMin(), 'max' => $aquarium->getKhMax()],
            'no2'=> ['min' => $aquarium->getNo2(),   'max' => null],
            'no3'=> ['min' => $aquarium->getNo3(),   'max' => null],
            'nhx'=> ['min' => $aquarium->getNhx(),   'max' => null],
            'conductivite' => ['min' => null,        'max'=> $aquarium->getConductiviteMax()],
        ];
        return $this->render('aquarium/show.html.twig', [
            'aquarium' => $aquarium,
            'limits' => $limits
        ]);
    }

    #[Route('/aquarium/{id}', name: 'app_aquarium_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(
        Request $request,
        Aquarium $aquarium,
        EntityManagerInterface $em
        ): Response
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

    #[Route('/aquarium/{id}/evenements', name: 'app_aquarium_evenements', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function getEvents(Aquarium $aquarium, Request $request): JsonResponse
    {
        // Vérifier que l'aquarium appartient à l'utilisateur connecté
        if ($aquarium->getUser() !== $this->getUser()) {
            return new JsonResponse([], 403);
        }

        $events = [];

        // Récupérer les paramètres start et end de FullCalendar
        $startParam = $request->query->get('start');
        $endParam = $request->query->get('end');
        // Convertir en DateTimeImmutable
        $start = $startParam ? new DateTimeImmutable($startParam) : null;
        $end = $endParam ? new DateTimeImmutable($endParam) : null;

        // ===== TESTS (analyses) =====
        foreach ($aquarium->getTests() as $test) {
            $testDate = $test->getDate();

            // Filtrer si start/end sont fournis
            if ($start && $testDate < $start) {
                continue;
            }
            if ($end && $testDate > $end) {
                continue;
            }

            $events[] = [
                'title' => 'Analyse',
                'start' => $test->getDate()->format('Y-m-d'),
                'color' => ($this->getUserApp()?->getUiPreferences()?->getColorEventTest() ?? UserEventColors::EVENT_TEST),
                'extendedProps' => [
                    'description' => $test->getEventDescription(),
                    'type' => 'test',
                ],
            ];
        }

        // ===== ÉVÉNEMENTS =====
        foreach ($aquarium->getEvenements() as $evenement) {
            $eventDate = $evenement->getDate();

            // Filtrer si start/end sont fournis
            if ($start && $eventDate < $start) {
                continue;
            }
            if ($end && $eventDate > $end) {
                continue;
            }

            $events[] = [
                'title' => $evenement->getCategorie()->getName(),
                'start' => $evenement->getDate()->format('Y-m-d'),
                'color' => ($this->getUserApp()?->getUiPreferences()?->getColorDefault() ?? UserEventColors::DEFAULT_EVENT),
                'extendedProps' => [
                    'description' => $evenement->getDescription() ?? '',
                    'type' => 'event',
                ],
            ];
        }

        // ===== Plantes =====
        foreach ($aquarium->getPlantes() as $plante) {
            $date = $plante->getDateAjout();

            // Filtrer si start/end sont fournis
            if ($start && $date < $start) {
                continue;
            }
            if ($end && $date > $end) {
                continue;
            }

            $events[] = [
                'title' => 'Ajout Plante',
                'start' => $plante->getDateAjout()->format('Y-m-d'),
                'color' => ($this->getUserApp()?->getUiPreferences()?->getColorAddPlant() ?? UserEventColors::ADD_PLANT),
                'extendedProps' => [
                    'description' => $plante->getName() . '(' . $plante->getEspece()->getName() . ')',
                    'type' => 'plante',
                ],
            ];
        }

        // ===== Poissons =====
        foreach ($aquarium->getPoissons() as $poisson) {
            $date = $poisson->getDateAcquisition();

            // Filtrer si start/end sont fournis
            if ($start && $date < $start) {
                continue;
            }
            if ($end && $date > $end) {
                continue;
            }

            $events[] = [
                'title' => 'Ajout Poisson',
                'start' => $poisson->getDateAcquisition()->format('Y-m-d'),
                'color' => ($this->getUserApp()?->getUiPreferences()?->getColorAddFish() ?? UserEventColors::ADD_FISH),
                'extendedProps' => [
                    'description' => $poisson->getName() . '(' . $poisson->getEspece()->getName() . ')',
                    'type' => 'poisson',
                ],
            ];
        }

        return new JsonResponse($events);
    }
}
