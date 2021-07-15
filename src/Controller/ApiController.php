<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Entity\Category;
use App\Entity\Post;

/**
 * @Rest\Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/menu", name="app_menu_list")
     * @Rest\View(StatusCode = 200, serializerGroups={"menu"})
     */
    public function getMenu()
    {
        return $this->getDoctrine()->getRepository(Category::class)->findBy(array("active" => true));
    }

    /**
     * @Rest\Get("/posts", name="app_posts_list")
     * @Rest\View(StatusCode = 200, serializerGroups={"post"})
     */
    public function getPostList()
    {
        return $this->getDoctrine()->getRepository(Post::class)->findBy(array("active" => true));
    }

    /**
     * @Rest\Get("/posts/{slug}", name="app_post_show")
     * @Rest\View(StatusCode = 200, serializerGroups={"post"})
     */
    public function getPost(String $slug)
    {
        return $this->getDoctrine()->getRepository(Post::class)->findOneBy(array("active" => true, "slug" => $slug));
    }
}
