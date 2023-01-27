<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $adress = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $content = $form->get('content')->getData();
            
            $email = (new Email())
            ->from($adress)
            ->to('admin@admin.com')
            ->subject($subject)
            ->text($content);

            $mailer->send($email);

            return $this->redirectToRoute('app_home');
           
        }
        return $this->renderForm('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form 
            
        ]);
    }
}
