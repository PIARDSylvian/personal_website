<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Category '.($i));
            $category->setActive(true);
            $manager->persist($category);
            $this->addReference('category_'.$i, $category);
        }
        
        $manager->flush();
    }
}
