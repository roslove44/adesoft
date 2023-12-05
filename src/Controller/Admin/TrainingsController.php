<?php

namespace App\Controller\Admin;

use App\Entity\Trainings;
use App\Form\TrainingsType;
use App\Repository\TrainingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingsController extends AbstractController
{
    #[Route('/administration/formations', name: 'app_admin_trainings')]
    public function trainings(Request $request, EntityManagerInterface $manager, TrainingsRepository $trainingsRepository): Response
    {
        $training = new Trainings;
        $trainingForm = $this->createForm(TrainingsType::class, $training);
        $trainingForm->handleRequest($request);
        if ($trainingForm->isSubmitted() && $trainingForm->isValid()) {
            $manager->persist($training);
            $manager->flush();
            $this->addFlash('success', 'Formation ajoutée avec succès');
            return $this->redirectToRoute("app_admin_trainings");
        }


        $trainings = $trainingsRepository->findBy([], ['start_at' => 'DESC']);
        $trainingForm = $trainingForm->createView();
        return $this->render('admin/trainings.html.twig', compact('trainingForm', 'trainings'));
    }

    #[Route('/administration/formations/editer/{id}', name: 'app_admin_trainings_edit')]
    public function editTraining(
        Trainings $training,
        Request $request,
        EntityManagerInterface $manager,
        TrainingsRepository $trainingsRepository
    ): Response {
        $trainingForm = $this->createForm(TrainingsType::class, $training);
        $trainingForm->handleRequest($request);
        if ($trainingForm->isSubmitted() && $trainingForm->isValid()) {
            $manager->persist($training);
            $manager->flush();
            $this->addFlash('success', 'Mise à jour éffectuée avec succès');
            return $this->redirectToRoute("app_admin_trainings");
        }

        $trainings = $trainingsRepository->findBy([], ['start_at' => 'DESC']);
        $trainingForm = $trainingForm->createView();
        return $this->render('admin/editTraining.html.twig', compact('trainingForm'));
    }

    #[Route('/administration/formations/supprimer/{id}', name: 'app_admin_trainings_delete', methods: ['DELETE'])]
    public function deleteTraining(
        Trainings $training,
        Request $request,
        EntityManagerInterface $manager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $training->getId(), $data['_token'])) {
            // Le token csrf est valide
            $manager->remove($training);
            $manager->flush();
            return new JsonResponse(['success' => true], 200);
        }
        return new JsonResponse(['error' => 'Token Invalide !']);
    }

    #[Route('/administration/formations/participants/{id}', name: 'app_admin_trainings_participants')]
    public function trainingsParticipants(Request $request, Trainings $training): Response
    {
        $participants = $training->getParticipants();
        return $this->render('admin/trainingParticipants.html.twig', compact('training', 'participants'));
    }
}
