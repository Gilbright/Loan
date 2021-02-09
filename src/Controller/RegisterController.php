<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register_project", name="app_register")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('forms/register_client.html.twig');
    }


}
