<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\QuoteType;
use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_main')]
class MainController extends AbstractController
{
    #[Route('', name: '')]
    public function index(Request $request, SendMailService $mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();
            $reply_to = $data['client_email'];
            $company_email = $this->getParameter('company_email');
            $mailer->send(
                $company_email,
                $company_email,
                "Prise de Contact : " . $data['name'],
                'contact',
                $data,
                $reply_to
            );
            $this->addFlash('success', "Nous vous remercions d'avoir pris le temps de remplir notre formulaire de contact. Nous avons bien reçu votre demande et nous vous reviendrons dans les plus brefs délais.");
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
    public function quote(Request $request, SendMailService $mailer): Response
    {
        $quoteForm = $this->createForm(QuoteType::class);
        $quoteForm->handleRequest($request);

        if ($quoteForm->isSubmitted() && $quoteForm->isValid()) {
            $data = $quoteForm->getData();
            $reply_to = $data['email'];
            $company_email = $this->getParameter('company_email');
            $data['client_email'] = $data['email'];
            unset($data['email']);
            $mailer->send(
                $company_email,
                $company_email,
                $data['subject'] . " : " . $data['name'],
                'quote',
                $data,
                $reply_to
            );
            $this->addFlash(
                'success',
                "Nous vous remercions d'avoir pris le temps de remplir notre formulaire de contact.
                 Nous avons bien reçu votre demande et nous vous reviendrons dans les plus brefs délais."
            );
            return $this->redirectToRoute('app_main_quote');
        }

        $quoteForm = $quoteForm->createView();
        return $this->render('main/quote.html.twig', compact('quoteForm'));
    }
}
