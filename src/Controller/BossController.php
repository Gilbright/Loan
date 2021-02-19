<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BossController extends AbstractController
{
    /**
     * @Route("/recent", name="app_recent")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render('tables/recent_projects.html.twig');
    }
}
