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
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|login|logout|_(profiler|wdt)).*"}, name="app_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', []);
    }
}
