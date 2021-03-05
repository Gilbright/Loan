<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/secretaire_view", name="app_secretaire_view")
     * @return Response
     */
    public function index1(): Response
    {
        return $this->render('secretary_view.html.twig');
    }



    /**
     * @Route("/boss_view", name="app_boss_view")
     * @return Response
     */
/*
    public function index3(): Response
    {
        return $this->render('pages/statusRedirections/boss_view.html.twig');
    }
*/
    /**
     * @Route("/tresorier_view", name="app_tresorier_view")
     * @return Response
     */
    public function index4(): Response
    {
        return $this->render('accountant_view.html.twig');
    }

}
