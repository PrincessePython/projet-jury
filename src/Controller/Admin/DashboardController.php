<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\Addresses;
use App\Entity\Categories;
use App\Entity\OrdersDetails;
use App\Controller\Admin\UsersCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SubMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

#[Route('/admin'), IsGranted('ROLE_ADMIN')]

class DashboardController extends AbstractDashboardController
{
    #[Route('/', name:'admin')]

    public function index(): Response
    {
        // return parent::index();
    
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());  
   }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Playducatif Ecomm Jury');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Accueil', 'fa fa-home', 'home');

        yield MenuItem::linkToDashboard('Utilisateurs', 'fa-solid fa-users-gear');
        yield MenuItem::linkToCrud('Adresses','fa fa-home', Addresses::class );

        yield MenuItem::linkToCrud('Produits', 'fa-solid fa-puzzle-piece', Products::class);
        yield MenuItem::linkToCrud('Categories','fas fa-list', Categories::class );
        yield MenuItem::linkToCrud('Images', 'fa fa-photo', Images::class);

        // les liens suivants seront desactivés une fois le systeme de paiement est mise en ligne.
        // yield MenuItem::section('Orders');
        // yield MenuItem::linkToCrud('Commandes', 'fa fa-truck', Orders::class );
        // yield MenuItem::linkToCrud('Détailles des commandes', 'fa fa-list', OrdersDetails::class);

    }
}

