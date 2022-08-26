<?php

namespace App\Controller;



use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
      
       
        //creation du formulaire
        $form = $this->createForm(ContactType::class);
   
        //handlerequest methode
        $form->handleRequest($request);
        //condition du formulaire si tu es remplis et valid
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', message: 'Merci de nous avoir contacter.Je vais vous répondre dansles meilleurs délais');
           
            // vider le formulaire et le transmettre a la bdd
            $this->entityManager->flush();
            // mail a reparemeter
           // $mail = new Mail();
           // $mail->send('lavoiedudragonidf@gmail.com', 'la voie du Dragon', 'vous avez reçu un nouveau contact', '');
            $this->addFlash('notice', 'votre message a bien étè envoyé');
        }
            //envoyer formulaire sur le vue de twig
        return $this->render('contact/index.html.twig', [
                'form' => $form->createView(),
                
        ]);
    }
}
