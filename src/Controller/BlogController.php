<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
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
 
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {

        $blogs = $this->entityManager->getRepository(Blog::class)->findAll();

        
        return $this->render('blog/index.html.twig', [
            'blogs' => $blogs,
           
        ]);
    }
}
