<?php

namespace App\Controller;


use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
      
        //creation du formulaire
        $form = $this->createForm(ContactType::class);
   
        //handlerequest methode
        $form->handleRequest($request);
        //condition du formulaire si tu es remplis et valid

        if ($form->isSubmitted() && $form->isValid()) {
             $this->addFlash('notice', "Merci de nous avoir contacter, votre message a bien étè envoyé");
            //Email avec mailer google
            $email = (new Email())
            ->from('lavoiedudragonidf@gmail.com')
            ->to('contact@lavoiedudragon.fr')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Test')
            ->text('Félécitations, le mail fonctionne')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

           return $this->redirectToRoute('app_contact');
        }
            //envoyer formulaire sur le vue de twig
        return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
                
        ]);
    }
}
