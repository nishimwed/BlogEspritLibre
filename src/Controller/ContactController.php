<?php

namespace App\Controller;

use PharIo\Manifest\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

     
    
    #[Route("/contact/submit", name: "contact_form_submit", methods : "POST")]

    public function handleFormSubmit(Request $request, MailerInterface $mailer): Response
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $message = $request->request->get('message');

        // Envoi de l'email
        $emailMessage = (new MimeEmail())
            ->from($email)
            ->to('nishimwedanychaste@gmail.com')
            ->subject('Contact Form Submission')
            ->text(
                "Name: $name\n" .
                "Email: $email\n" .
                "Message:\n$message"
            );

        $mailer->send($emailMessage);

        $this->addFlash('success', 'Your message has been sent!');

        return $this->redirectToRoute('app_contact');
    }
}
