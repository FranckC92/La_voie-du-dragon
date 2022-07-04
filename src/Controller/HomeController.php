<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        //créations cookies avec propriété nom/valeur/expiration/path(home)/domaine/secu hhtps & http
        $cookie = new Cookie('la voie du Dragon',
                            'blog',
                            strtotime('tomorrow'),
                            '/',
                            'digitaldev.fr',
                            true,
                            true);
                        

        return $this->render('home/index.html.twig');
    }
}
