<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $category = $categoriesRepository->findBy([],['id'=>'asc']);

        return $this->render('home/index.html.twig', [
            'categories'=>$category,            

        ]);
    }

    // #[Route('/products', name: 'products')]
    // public function products(ProductsRepository $productsRepository): Response
    // {
    //     $products = $productsRepository->findAll();
    //     return $this->render('products/index.html.twig', [
    //         'products' => $products,
    //     ]);
    // }
    #[Route('/products', name: 'products')]
    public function products(ProductsRepository $productsRepository): Response
    {   
        $products = $productsRepository->findAll();
        return $this->render('products/index.html.twig', [
            'products' => $products
        ]);
    }


    #[Route('/categories', name: 'list')]
    public function categories(): Response
    {
        return $this->render('categories/list.html.twig');
    }

}
