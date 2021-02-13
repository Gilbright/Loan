<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('pages/status/en_attente_etude.html.twig');
    }

    /**
     * @Route("/attente_etude/{projectId}", name="app-view")
     * @param string|null $projectId
     * @return Response
     */
    public function attente($projectId): Response
    {
       // dd($projectId);
        return $this->render('pages/registered_project_clients.html.twig');
    }

    /**
     * @Route("/attente_control/{projectId}", name="app-view1")
     * @param string|null $projectId
     * @return Response
     */
    public function attenteControl($projectId): Response
    {
        return $this->render('pages/status/en_attente_de_control.html.twig');
    }

    /**
     * @Route("/attente_etude/{projectId}", name="app-view2")
     * @param string|null $projectId
     * @return Response
     */
    public function attenteEtude($projectId): Response
    {
        return $this->render('pages/status/en_attente_etude.html.twig');
    }


}
