<?php

namespace App\Controller;

use App\Entity\Addresses;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddressRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// #[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    // ici cela donnera https://playducatif.fr/profile
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
    
    // ici la route https://playducatif.fr/profile/modify
    #[Route('/modify', name: 'modify')]
    public function modify(Request $request, EntityManagerInterface $entityManager): Response
    {
    
        $address = new Addresses();
        $form = $this->createForm(AddressRegistrationFormType::class, $address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){

            $address->setAddress($address->getAddress());
            $address->setZipcode($address->getZipcode());
            $address->setCity($address->getCity());
            $address->setCountry($address->getCountry());

            /*
            Pour valider les données avant les mettre dans la bdd
            if ($form->isSubmitted && $form->isValid())
            */
            
            // $address = $form->getData();

            // je mets les infos dans la base des données
            $entityManager->persist($address);
            $entityManager->flush();

        }

        return $this->render('profile/modify.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

  

    // ici cela donnera https://playducatif.fr/profile/commandes
    #[Route('/commandes', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
        ]);
    }
}
