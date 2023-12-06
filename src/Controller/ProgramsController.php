<?php

namespace App\Controller;

use App\Repository\ProgramsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProgramsController extends AbstractController
{
    #[Route('/get/programs', name: 'app_programs', methods: ['GET'])]
    public function index(ProgramsRepository $programsRepository, NormalizerInterface $normalizer): JsonResponse
    {
        $programs = $programsRepository->findBy([], ['year' => 'DESC']);
        $programsArray = [];
        foreach ($programs as $program) {
            $programsArray[] = $normalizer->normalize($program);
        }
        return new JsonResponse(['programs' => $programsArray], 200);
    }
}
