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

        if (empty($this->getDoctrine()->getRepository(Category::class)->findBy(array("active" => true)))) {
            $entityManager = $this->getDoctrine()->getManager();

            for ($i=1; $i <= 5 ; $i++) { 
                $category = new Category();
                $category->setName('Category '.$i);
                $category->setSlug('category-'.$i);
                $category->setActive(true);
    
                $entityManager->persist($category);
    
                for ($j=1; $j <= 5 ; $j++) {
                    $slugIdx = $i.$j;
                    $post = new Post();
                    $post->setTitle('Post '.$j);
                    $post->setSlug('post-'.$slugIdx);
                    $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
                    $post->setCreatedAt(\DateTimeImmutable::createFromMutable(new \DateTime('NOW')));
                    $post->setActive(true);
                    $post->setCategory($category);
    
                    $entityManager->persist($post);
                }
            }
            $entityManager->flush();
        }
        return $this->render('base.html.twig', []);
    }
}
