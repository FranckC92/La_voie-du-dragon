<?php

namespace App\Controller;



use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
      
        //creation du formulaire
        $form = $this->createForm(ContactType::class);
   
        //handlerequest methode
        $form->handleRequest($request);
        //condition du formulaire si tu es remplis et valid

        if ($form->isSubmitted() && $form->isValid()) {
             $this->addFlash('notice', "Merci de nous avoir contacter, votre message a bien étè envoyé");
            // mail a reparemeter
           // $mail = new Mail();
           // $mail->send('lavoiedudragonidf@gmail.com', 'la voie du Dragon', 'vous avez reçu un nouveau contact', '');
           return $this->redirectToRoute('app_contact');
        }
            //envoyer formulaire sur le vue de twig
        return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
                
        ]);
    }
}
