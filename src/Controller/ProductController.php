<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    //utilise doctrine pour recuper mes objets
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/nos-articles', name: 'products')]
    public function index(Request $request): Response
    {
     
        //declare et recupere donnes repoostyory fichier
        $products = $this->entityManager->getRepository(Product::class)->findAll();
      
        //barre de rechercher et enoie du form lie a laclasse search
        $search = new Search();
        $form = $this->createForm( SearchType::class, $search);
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form'=> $form->createView(),
        ]);
    }

    //2 eme fonction
    #[Route('/article/{slug}', name: 'product')]
    public function show($slug): Response
    {
        
        //declare et recupere donnes repoostyory fichier
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
      
        //redirection si tu trouve pas de produits
        if (!$product) {
            return $this->redirectToRoute('products');

        }
        //barre de rechercher
        return $this->render('product/show.html.twig', [
            'product' => $product
            
        ]);
    } 
}
