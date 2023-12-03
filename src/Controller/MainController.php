<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\NewsletterType;
use App\Form\QuoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_main')]
class MainController extends AbstractController
{
    #[Route('', name: '')]
    public function index(Request $request): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            dd($contactForm->getData());

            return $this->redirectToRoute('app_main');
        }

        $contactForm = $contactForm->createView();
        return $this->render('main/index.html.twig', compact('contactForm'));
    }

    #[Route('nos-services', name: '_services')]
    public function services(): Response
    {
        return $this->render('main/service.html.twig', []);
    }

    #[Route('a-propos', name: '_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig', []);
    }

    #[Route('obtenir-un-devis', name: '_quote')]
    public function quote(Request $request): Response
    {
        $quoteForm = $this->createForm(QuoteType::class);
        $quoteForm->handleRequest($request);

        if ($quoteForm->isSubmitted() && $quoteForm->isValid()) {
            dd($quoteForm->getData());

            return $this->redirectToRoute('app_main');
        }

        $quoteForm = $quoteForm->createView();
        return $this->render('main/quote.html.twig', compact('quoteForm'));
    }
}
