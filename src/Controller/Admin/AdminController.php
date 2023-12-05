<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdminController extends AbstractController
{
    #[Route('/administration', name: 'app_admin')]
    public function index(Request $request): Response
    {
        return $this->render('admin.html.twig');
    }

    #[Route('/administration/formations', name: 'app_admin_trainings')]
    public function trainings(Request $request): Response
    {
        return $this->render('admin/trainings.html.twig');
    }
}
