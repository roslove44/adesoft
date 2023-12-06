<?php

namespace App\Controller\Admin;

use App\Entity\Programs;
use App\Form\ProgramsType;
use App\Repository\NewslettersRepository;
use App\Repository\ProgramsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/administration', name: 'app_admin')]
    public function index(Request $request): Response
    {
        return $this->redirectToRoute('app_admin_trainings');
    }

    #[Route('/administration/newsletter', name: 'app_admin_newsletter')]
    public function newsletter(NewslettersRepository $newslettersRepository): Response
    {
        $newsletters = $newslettersRepository->findAll();
        return $this->render('admin/newsletter.html.twig', compact('newsletters'));
    }

    #[Route('/administration/programmes-annuels', name: 'app_admin_programs')]
    public function programs(
        ProgramsRepository $programsRepository,
        Request $request,
        KernelInterface $kernel,
        EntityManagerInterface $manager
    ): Response {
        $program = new Programs();
        $programsForm = $this->createForm(ProgramsType::class, $program);
        $programsForm->handleRequest($request);
        if ($programsForm->isSubmitted() && $programsForm->isValid()) {
            $file = $programsForm->get('fileSrc')->getData();
            if ($file) {
                try {
                    $directory = $kernel->getProjectDir() . '/public/admin/programs/';
                    $fileName = "Programme_de_Formation_" . $program->getYear() . '.' . $file->guessExtension();

                    // Stockez le nom du fichier dans l'entité ou faites toute autre opération nécessaire
                    $program->setFileSrc($fileName);

                    $manager->persist($program);
                    $manager->flush();
                    $file->move($directory, $fileName);
                } catch (\Throwable $th) {
                    $this->addFlash('danger', "Un programme existe déjà pour l'année définie");
                    return $this->redirectToRoute('app_admin_programs');
                }
            }
        }

        $programs = $programsRepository->findAll();
        $programsForm = $programsForm->createView();
        return $this->render('admin/programs.html.twig', compact('programsForm', 'programs'));
    }

    #[Route('/administration/programmes_annuels/suppression/{id}', name: 'app_admin_programs_delete', methods: ['DELETE'])]
    public function deletePrograms(
        Programs $program,
        Request $request,
        KernelInterface $kernel,
        EntityManagerInterface $manager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $data['_token'])) {
            // Le token csrf est valide
            $fileSrc = $kernel->getProjectDir() . '/public/admin/programs/' . $program->getFileSrc();
            unset($fileSrc);
            $manager->remove($program);
            $manager->flush();

            return new JsonResponse(['success' => true], 200);
        }
        return new JsonResponse(['error' => 'Token Invalide !']);
    }
}
