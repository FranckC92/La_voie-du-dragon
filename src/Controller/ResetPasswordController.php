<?php

namespace App\Controller;


use App\Entity\User;
use DateTimeImmutable;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{
    // mets fonction entity mananger pour permmettre de recupere donnes dans bdd
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }
    #[Route('/reset/password', name: 'app_reset_password')]
    public function index(Request $request): Response
    {
         //conditons interdir d arriver dessus si on est connecte
         if($this->getUser()){
            //renvoye a la page home
            return $this->redirectToRoute('app_home');
        }
        //condition if si l email a nie été recupéré
        if ($request->get('email')){
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
                //si mon ux existe bien et dans certains conditions alors plusieurs operation resetpassowrd
            if ($user) {
                //enregister en base de resest password avec User/Token/setCreatedAt
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(Uniqid());
                $reset_password->setCreatedAt(new DateTimeImmutable());
                $this->entityManager->persist($reset_password);
                // on envoye a la bdd
                $this->entityManager->flush();
                //Envoyer un email à l ux avec un lien pour remettre à jour le mot de passe
                $url = $this->generateUrl('update_password', [
                    'token' =>$reset_password->getToken()
                ]);
                $content = "Bonjour ".$user->getFirstname()."</br>Vous avez demandé à renitialiser votre mot de passe sur 
                            votre site HelpDevIdf.</br>";
                $content = "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>Mettre à jour votre
                             mot de passe</a>.";
               // $mail = new Mail();
               // $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(),'Réinitialiser votre mot de
                //         passe ', $content);
                $this->addFlash('notice', 'vous allez recevoir un mail de renitialisation de votre mot de passe');
            } else {
                $this->addFlash('notice', 'cette adresse email est inconnue dans notre base de données');
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    
    #[Route('/modifier-password/{token}', name: 'update_password')]

    public function update(Request $request, $token, UserPasswordHasherInterface $encoder)
    {
        //je vais chercher rese mon entree reste passwword associé t 
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        //si il n existe tu peux faire un renvoi sur la route
        if (!$reset_password) {
            return $this->redirectToRoute('app_reset_password');
        }
        // verifier createdAt = now = 2h 
        $now = new \DateTime();
        if ($now > $reset_password->getCreatedAt()->modify('+ 2 hour')) {
            //on vas rajouter pour faire notificitaions addflash
            $this->addFlash('notice', 'Votre demande de mot de passe a expiré.Merci de la renouveller.');
            return $this->redirectToRoute('app_reset_password');
        }
        //Rendre une vue avec mot de passe et confirmez votre mot de passe
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        // condition if si le formulaier a bien étè remplis et validé
        if ($form->isSubmitted() && $form->isValid()) {
                $new_pwd= $form->get('new_password')->getData();
        //encodage mot de passe
            $password = $encoder->hashPassword($reset_password->getUser(),$new_pwd);
            $reset_password->getUser()->setPassword($password);
        //transmettre a la bdd
        $this->entityManager->flush();
        // notification
        $notification = 'Votre mot de passe a bien été mis à jour.';
        // methode addflash un message court et redirection de l ux vers la page de connexion
        $this->addFlash('notice', 'votre mot de passe a bien étè mis à jour.');
        return $this->redirectToRoute('app_login');
    }
        // envoye mon formulaire à twig avec createView
        return $this->render('reset_password/update.html.twig', [
            'form'=>$form->createView()
        ]);
    } 
}
