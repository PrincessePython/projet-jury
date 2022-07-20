<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Addresses;
use Symfony\Component\Mime\Address;
use App\Controller\Admin\AddressesCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('first_name'),
            TextField::new('last_name'),
            TextField::new('telephone'),
            EmailField::new('email'),
            TextField::new('password'),
            DateField::new('date_of_birth'),
            ArrayField::new('roles'),
            DateTimeField::new('created_at')->setTimezone('Europe/Paris'),
            AssociationField::new('addresses'),
            
       ];
    }
    
}
