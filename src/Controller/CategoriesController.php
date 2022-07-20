<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name:'categories_')]
class CategoriesController extends AbstractController
{
    // #[Route('/', name: 'index')]
    // public function index(): Response
    // {
    //     return $this->render('categories/index.html.twig', [
    //         'controller_name' => 'CategoriesController',
    //     ]);
    // }

    #[Route('/{slug}', name: 'list')]
    public function list(Categories $category): Response
    {

        // je veux tous les produits de la categorie choisie
        $products = $category->getProducts();

        // syntax 1 avec compact:
        // return $this->render('categories/list.html.twig', compact('category', 'products'));

        // syntax 2 classique:
        return $this->render('categories/list.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);

    }
}
