<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/api/menu")
     * @Rest\View(StatusCode = 201)
     */
    public function getMenu()
    {
        $test = ['aaa'];
        return $test;
    }
}
