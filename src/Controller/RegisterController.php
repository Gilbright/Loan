<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/readres", name="app_register")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/consult_status.html.twig');
    }

    /**
     * @Route("/secretaire_view", name="app_secretaire_view")
     * @return Response
     */
    public function index1(): Response
    {
        return $this->render('pages/statusRedirections/secretaire_view.html.twig');
    }

    /**
     * @Route("/expert_view", name="app_expert_view")
     * @return Response
     */
    public function index2(): Response
    {
        return $this->render('pages/statusRedirections/expert_view.html.twig');
    }

    /**
     * @Route("/boss_view", name="app_boss_view")
     * @return Response
     */
    public function index3(): Response
    {
        return $this->render('pages/statusRedirections/boss_view.html.twig');
    }

    /**
     * @Route("/tresorier_view", name="app_tresorier_view")
     * @return Response
     */
    public function index4(): Response
    {
        return $this->render('pages/statusRedirections/tresorier_view.html.twig');
    }

}
