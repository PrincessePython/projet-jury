<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactUsController extends AbstractController
{
    #[Route('/contact/us', name: 'app_contact_us')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        // recuperation des données saisies par l'utilisateur = $request
        $form->handleRequest($request);

        // vérification si les données excistent et ils sont coorectes, et si le formulaire à été soumis 
        if ($form->isSubmitted() && $form->isValid()){

            // récuperation des données

            $userEmail = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $message = $form->get('message')->getData();

            // préparation d'email
            $email = (new Email())
            ->from($userEmail)
            ->to('mailer@portfolio.codeuse.me')
            ->replyTo('mailer@portfolio.codeuse.me')
            ->subject($subject)
            ->text($message);
        
            // envoyer l'email    
            $mailer->send($email);
            
            // afficher le message flash pour informer l'utilisateur que son email a bien été envoyé
            $successMsg = $this->addFlash('success', 'Merci, votre message à bien été envoyé. Nous revenons vers vous très rapidement !');
            // redireger vers la page d'acceuil du site
            return $this->redirectToRoute('home');
        }


        return $this->renderForm('contact_us/index.html.twig', [
            'controller_name' => 'ContactUsController',
            'form' => $form
        ]);
    }
}
