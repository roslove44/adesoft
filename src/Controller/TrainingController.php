<?php

namespace App\Controller;

use App\Form\RequestTrainingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    #[Route('/formations', name: 'app_training')]
    public function index(): Response
    {
        return $this->render('training/index.html.twig', [
            'controller_name' => 'TrainingController',
        ]);
    }

    #[Route('/formations/s-inscrire/', name: 'app_training_request')]
    public function inscription(Request $request): Response
    {
        $trainingRequestForm = $this->createForm(RequestTrainingType::class);
        $trainingRequestForm->handleRequest($request);

        if ($trainingRequestForm->isSubmitted() && $trainingRequestForm->isValid()) {
            dd($trainingRequestForm->getData());

            return $this->redirectToRoute('app_main');
        }

        $trainingRequestForm = $trainingRequestForm->createView();
        return $this->render('training/request.html.twig', compact('trainingRequestForm'));
    }
}
