<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $notification = null;
        //creation du formulaire
        $form = $this->createForm(ContactType::class,);
        //handlerequest methode
        $form->handleRequest($request);
        //condition du formulaire si tu es remplis et valid
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', message: 'Merci de nous avoir contacter.Je vais vous répondre dansles meilleurs délais');
       
            //email
            $mail = new Mail();
            $mail->send('lavoiedudragonidf@gmail.com', 'la voie du Dragon', 'vous avez reçu un nouveau contact', '');
         }
            //envoyer formulaire sur le vue de twig
        return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
                'notification' => $notification
        ]);
    }
}
