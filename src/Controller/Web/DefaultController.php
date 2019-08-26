<?php

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return new Response('Hello world');
    }
}
