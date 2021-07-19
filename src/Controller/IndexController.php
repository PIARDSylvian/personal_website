<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Post;

class IndexController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|_(profiler|wdt)).*"}, name="index")
     * @return Response
     */
    public function index(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        for ($i=0; $i <= 5 ; $i++) { 
            $category = new Category();
            $category->setName('Category '.$i);
            $category->setActive(true);

            $entityManager->persist($category);

            for ($i=0; $i <= 5 ; $i++) {
                $post = new Post();
                $post->setTitle('Post '.$i);
                $post->setSlug('post-'.$i);
                $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
                $post->setCreatedAt(new \DateTime('NOW'));
                $post->setActive(true);

                $entityManager->persist($post);
            }
        }
        $entityManager->flush();

        return $this->render('base.html.twig', []);
    }
}
