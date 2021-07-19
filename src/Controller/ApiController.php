<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[\w\d\s-]+",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="category",
     *     requirements="\d+",
     *     nullable=true,
     *     description="The category to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="desc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of movies per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\View(StatusCode = 200, serializerGroups={"post"})
     */
    public function getPostList(ParamFetcherInterface $paramFetcher)
    {
        return $this->getDoctrine()->getRepository(Post::class)->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('category'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
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
