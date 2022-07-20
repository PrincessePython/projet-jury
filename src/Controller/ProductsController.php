<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// je définit le chemain par defaut 
#[Route('/products', name: 'products_')]

class ProductsController extends AbstractController
{

    // #[Route('/', name: 'index')]
    // public function index(): Response
    // {
        
    //     return $this->render("products/index.html.twig");
        

        // aller chercher les produits dans la bd
        // ici code pour afficher dans le index.twig
        
    // }

    // on utilise le slug ici pour un joli url et pour aller chercher le produit par le slug
    #[Route('/{slug}/{id}', name: 'details')]
    public function details(ProductsRepository $productsRepository, $slug, $id): Response
    {
        // dd($products);
        // dd($products->getPrice());
        $product = $productsRepository->find($id);
        

        return $this->render('products/details.html.twig', [
            'product' => $product
        ]);
    }    
}
