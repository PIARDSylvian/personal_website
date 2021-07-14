<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Category;

/**
 * @Rest\Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/menu")
     * @Rest\View(StatusCode = 201, serializerGroups={"menu"})
     */
    public function getMenu()
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName('category 1');
        $category->setActive(true);
        $em->persist($category);
        $category = new Category();
        $category->setName('category 2');
        $em->persist($category);

        $category = new Category();
        $category->setName('category 3');
        $category->setActive(true);
        $em->persist($category);
        
        
        $em->flush();

        return $this->getDoctrine()->getRepository(Category::class)->findBy(array("active" => true));
    }
}
