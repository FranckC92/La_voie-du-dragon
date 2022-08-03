<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPaswwordController extends AbstractController
{
    //rajoute le parametre entitymanager pour permettre de communiquer avec la bdd.
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/compte/modifie-mon-mot-de-passe', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder)
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        
        $form->handleRequest($request);
        // conditions si le form est bien remplis et valid alors
        if ($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('old_password')->getData();
          
            if ($encoder->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user,$new_pwd);
                
                $user->setPassword($password);
            //on envoie a la bdd
            $this->entityManager->flush();
            $notification = 'Votre mot de passe a bien été mis à jour.';

            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }
        }
        {# renvoie la vue sur twig et le formulaire sur twig #}
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
