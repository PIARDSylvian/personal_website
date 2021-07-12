<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", name="index")
     * @Route("/")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }
}
