<?php

namespace App\Service;

use Stripe\StripeClient;
use App\Entity\ShoppingCart;
use Symfony\Component\HttpFoundation\RequestStack;

class PaymentService
{
    private $shoppingCart;
    private $stripe;
    private $requestStack;
    
    // Je définie ce que j'ai besoin dans mon PaymentService
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->stripe = new StripeClient ("sk_test_51Lg4RqKqqUW5BhIuMPw9TgNrTb8ywYjDFOYp2qvqyJi8TdQ01OGIGYtI1yEikR6iej2UVaCw3Kdb0gG1Ac23aPzQ00qqgkER46");
    }

    // Je donne au stripe le numéro de session
    public function createPayment( ): string
    {

        $session = $this->requestStack->getSession();

        $panier = $session->get('cart');

        
        // je recupere mon panier
    //    $cart = $this->shoppingCart->getProducts();

       //je donne à stripe une liste vide des élements
       $items=[];
       // je parcours avec foreach mon panier pour construire la liste des items compatible avec stripe
       // pour chaque élemenet dans mon panier comme
       foreach ($cart as $product)
       {
            $items[] = [
                'amount' => $product->getPrice() * 100,
                'currency' => 'eur',
                'name' => $product->getName(),
                'quantity' => 1,
            ];
       }
    }

};