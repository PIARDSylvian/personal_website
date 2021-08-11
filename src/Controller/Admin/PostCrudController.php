<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityPermission('ROLE_ADMIN');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('slug')->hideOnIndex(),
            TextField::new('image')->hideOnIndex(),
            TextareaField::new('content')->hideOnIndex(),
            BooleanField::new('active'),
            DateTimeField::new('createdAt')->setFormTypeOption('view_timezone', 'Europe/Paris')->setFormat('dd/MM/yyyy HH:mm')->hideOnForm(),
            DateTimeField::new('updatedAt')->setFormTypeOption('view_timezone', 'Europe/Paris')->setFormat('dd/MM/yyyy HH:mm')->hideOnForm(),
            AssociationField::new('category')
        ];
    }
    
}
