<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter', methods: ['POST'])]
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        $email = $request->request->get('email');
        $constraint = new Assert\Email();

        $violations = $validator->validate($email, $constraint);
        if (count($violations) > 0) {
            // Le formulaire n'est pas valide, gestion des erreurs
            // dd($violations);
            return $this->redirect($request->headers->get('referer'));
        }
        // dd($email);
        return $this->redirect($request->headers->get('referer'));
    }
}
