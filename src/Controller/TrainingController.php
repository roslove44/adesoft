<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Entity\Trainings;
use App\Form\RequestTrainingType;
use App\Repository\TrainingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    #[Route('/formations', name: 'app_training')]
    public function index(TrainingsRepository $trainingsRepository): Response
    {
        $trainings = $trainingsRepository->findBy([], ['start_at' => 'DESC']);
        return $this->render('training/index.html.twig', compact('trainings'));
    }

    #[Route('/formations/s-inscrire/{id}', name: 'app_training_request')]
    public function inscription(
        Request $request,
        Trainings $training,
        EntityManagerInterface $manager
    ): Response {
        $participant = new Participants();
        $trainingRequestForm = $this->createForm(RequestTrainingType::class, $participant);
        $trainingRequestForm->handleRequest($request);

        if ($trainingRequestForm->isSubmitted() && $trainingRequestForm->isValid()) {
            $participant->setRegisteredAt(new \DateTimeImmutable("now"));
            $training->addParticipant($participant);

            $manager->persist($training);
            $manager->flush();

            $this->addFlash('success', "Votre demande d'inscription à la formation, a été soumise avec succès");

            return $this->redirectToRoute('app_training');
        }

        $trainingRequestForm = $trainingRequestForm->createView();
        return $this->render('training/request.html.twig', compact('trainingRequestForm', 'training'));
    }
}
