<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;


class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityPermission('ROLE_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')->hideOnIndex(),
            ChoiceField::new('color')->setChoices([
                "blue"=>"blue",
                "indigo"=>"indigo",
                "purple"=>"purple",
                "pink"=>"pink",
                "red"=>"red",
                "orange"=>"orange",
                "yellow"=>"yellow",
                "green"=>"green",
                "teal"=>"teal",
                "cyan"=>"cyan",
                "gray"=>"gray"
            ]),
            BooleanField::new('active')
        ];
    }
}
