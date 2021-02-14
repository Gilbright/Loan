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
     * @Route("/expert_view/{projectId}", name="app_expert_view")
     * @return Response
     */
    public function index2($projectId): Response
    {
        //TODO:  ici dans le twig on controle le choix des buttons en fonction du fait que l'expert soit en train d'etudier
        // un projet qui est en etat d'etude simple ou etape d'entretien
        // il reste a implementer la validation definitive du projet apres l'entretien pour son envoi au boss
        // la continuation plus tard qui retourne au dashboard et le reject complet qui passe d'abord par une confirmation par note ou alerte.

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
