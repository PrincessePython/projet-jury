<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            AssociationField::new('category_id')->autocomplete(),
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('product_reference'),
            TextField::new('editor'),
            MoneyField::new('price')->setNumDecimals(2)->setCurrency('EUR'),
            IntegerField::new('stock'),
            SlugField::new('slug')->setTargetFieldName('name'),
            DateTimeField::new('created_at')->setTimezone('Europe/Paris'),
            AssociationField::new('images'),
            // ImageField::new('images')->setBasePath('public/ressources')->setUploadDir('/images')->setUploadedFileNamePattern(['randomhash'], ['extention']),

            // AssociationField::new('addresses_id')->autocomplete(),


            
        ];
    }
    
}
