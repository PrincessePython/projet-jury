<?php

namespace App\Controller\Admin;

use App\Entity\OrdersDetails;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrdersDetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrdersDetails::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            AssociationField::new('orders'),
            AssociationField::new('products'),
            IntegerField::new('quantity'),
            MoneyField::new('price')->setNumDecimals(2)->setCurrency('EUR'),
        ];
    }
    
}
