<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountPaswwordController extends AbstractController
{
    #[Route('/compte/modifie-mon-mot-de-passe', name: 'app_account_paswword')]
    public function index(): Response
    {
        return $this->render('account/pasword.html.twig');
    }
}
