<?php

namespace App\Controller;

use App\Entity\User;
use App\Classe\Mail;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entityManager = $entitymanager;
    }
    #[Route('/register ', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder)
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getdata();
            //verifiie les mdp ci dessous/
            $search_mail = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($user->getEmail());
            $password = $encoder->hashPassword($user, $user->getPassword());
               $user->setPassword($password);
               // si l email n est pas present en base de donnes tu peux continuer (envouyer a la bdd) si c est pas le cas notification
               if (!$search_mail){
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $mail = new Mail();
           
            $notification = "Votre inscription s'est correctement déroulée.Veuillez vous
            connecter à votre compte, connexion en haut a droite de la barre de navigation";
               }else{
                $notification = "L'email existe déja. Merci d'essayer avec un autre email";
               }
         }
        //conditions si le formulaire remplis tu renvois sur la page connection
        if ($this->getUser()){
           
            return $this->redirectToRoute('app_login');
          // return $this->render('security/login.html.twig');
        } else {
        
        return $this->render('register/index.html.twig', [

            'form' => $form->createView(),
            'notification' => $notification
                                        ]); 
                }
    }
}

