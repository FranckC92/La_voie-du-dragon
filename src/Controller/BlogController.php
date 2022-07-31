<?php

namespace App\Controller;

use App\Classe\Search2;
use App\Entity\Blog;
use App\Form\Search2Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    //utilise doctrine pour recuper mes objets
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
 
    #[Route('/les-blogs', name: 'app_blogs')]
    public function index(Request $request): Response
    {

        $blogs = $this->entityManager->getRepository(Blog::class)->findAll();
        // declare ma variable search2 pour ma barre de recherche
        $search2 = new Search2;
        // envoyer mon formulaire search2type pour la barre de recherche
        $form = $this->createForm(Search2Type::class, $search2);

        return $this->render('blog/index.html.twig', [
            'blogs' => $blogs,
            ]);
    }
    #[Route('/mon-blog/{slug}', name: 'app_blog')]
    public function show($slug): Response
    {

        $blog = $this->entityManager->getRepository(Blog::class)->findOneBySlug($slug);

       
 
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            
        ]);
    }
}
