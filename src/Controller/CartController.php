<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/panier', name:'panier_')]

class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, ProductsRepository $productsRepository): Response
    {
        // dd($request);
        // var_dump($request);
        // recuperation de la session
        $session = $request->getSession();

        //si la partie cart exciste dans la session
        if ($session->get('cart')){
            // S'elle exciste, je recupere le panier
            $panier = $session->get('cart');
        }else{
            // Si le panier n'esxiste pas, on le crée
            $panier = [];
            $panier['id_product'] = [];
            $panier['reference'] = [];
            $panier['title'] = [];
            $panier['qqty'] = [];
            $panier['price'] = [];
            $panier['image'] = [];

            // Créer le panier dans la session
            $session->set('cart', $panier);

            // Je recupere le panier
            $panier = $session->get('cart');
        }

        // Est-ce que l'utilisateur demande un ajout dans panier ?

        if(isset($_POST['id_product']) && isset($_POST['qqty'])) {
            // Je remplie les-sous tableaux du panier
            $position = array_search($_POST['id_product'], $panier['id_product']);
            if($position === false){
                //  Je cherche les infos des produits dans la bdd anfin de recuper son prix, le titre et la reference 
                $product = $productsRepository->find($_POST['id_product']);
                $images = $product->getImages();
                if (isset($images[0])){
                    $image = $images[0];
                    $panier['image'][] = $image->getPath();
                }else{
                    $panier['image'][] = '350x350.png';

                }

                // Je rajoute le titre et le prix dans le sous-indices de panier

                $panier['id_product'][] = $_POST['id_product'];
                $panier['qqty'][] = $_POST['qqty'];
                $panier['title'][] = $product->getName(); 
                $panier['price'][] = $product->getPrice()/100 ;
                $panier['reference'][] = $product->getProductReference();
            }else{
                // le produit est present et la postion contient l'indice
                $panier['qqty'][$position] += $_POST['qqty'];
            }
            $session->set('cart', $panier);

            return $this->redirectToRoute('panier_index');
        }
        // var_dump($panier);
        
        
        // On met à jour le panier dans la session

        // Je recoupere le panier

        // $panier = $session->get('panier', []);
        // dd($panier);
        // dd($_POST);

        //var_dump($session);

        $totalQqty = 0;
        $totalAmmount = 0;
        for ($i=0; $i < count($panier['id_product']) ; $i++) { 
            $totalAmmount += $panier['qqty'][$i]*$panier['price'][$i];
            $totalQqty += $panier['qqty'][$i];
        }

        $nbItems = count($panier['id_product']);

        return $this->render('cart/index.html.twig',[
            'panier' => $panier,
            'nbItems' => $nbItems,
            'message' => '',
            'totalAmmount' => $totalAmmount,
            'totalQqty' => $totalQqty,
        ]);

        //calculer la quantité total des produits ajoutés
        // $infoPanierQQT = [];
        // $totalPanierPrix = [];
                    
    }

    #[Route('/paiement', methods:['POST', 'GET'], name:'pay')]
    public function pay(Request $request, ProductsRepository $productsRepository)
    {
        $session = $request->getSession();

            $panier = [];
            $panier['id_product'] = [];
            $panier['title'] = [];
            $panier['qqty'] = [];
            $panier['price'] = [];
            $panier['reference'] = [];

            // Créer le panier dans la session
            $session->set('cart', $panier);

            // On recupere le panier
            $panier = $session->get('cart');

 
        
            $nbItems = count($panier['id_product']);
            return $this->render('cart/index.html.twig',[
                'panier' => $panier,
                'nbItems' => $nbItems,
                'message' => 'Votre comande a bien été enregistée, merci de nous envoyer un cheque à l\'adresse suivante: 1 rue du Temple 75001 Paris',
                'totalAmmount' => 0,
                'totalQqty' => 0,
    
            ]);
    
    }

    #[Route('/vider', methods:['POST', 'GET'], name:'delete')]
    public function delete(Request $request, ProductsRepository $productsRepository)
    {
        $session = $request->getSession();

            $panier = [];
            $panier['id_product'] = [];
            $panier['title'] = [];
            $panier['qqty'] = [];
            $panier['price'] = [];
            $panier['reference'] = [];


            // Créer le panier dans la session
            $session->set('cart', $panier);

            // On recupere le panier
            $panier = $session->get('cart');

 
        
            $nbItems = count($panier['id_product']);
            return $this->render('cart/index.html.twig',[
                'panier' => $panier,
                'nbItems' => $nbItems,
                'message' => 'Votre panier est vide ! ',
                'totalAmmount' => 0,
                'totalQqty' => 0,
    
            ]);
    
    }



}
