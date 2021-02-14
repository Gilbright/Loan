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
     * @Route("/attente_ee/{projectId}", name="app-view")
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
     * @Route("/attente_etude/{projectId}", name="app-attente-etude-view")
     * @param string|null $projectId
     * @return Response
     */
    public function attenteEtude($projectId): Response
    {
        return $this->render('pages/status/en_attente_etude.html.twig');
    }

    /**
     * @Route("/analysis_on_going", name="app-view3")
     * @return Response
     */
    public function analysisOnGoing(): Response
    {
        return $this->render('pages/status/analysis_on_going.html.twig');
    }

    /**
     * @Route("/interview_step", name="app-interview-view")
     * @return Response
     */
    public function interviewStep(): Response
    {
        return $this->render('pages/status/interview_step.html.twig');
    }

    /**
     * @Route("/reanalyse", name="app-reanalyse-view")
     * @return Response
     */
    public function reanalyze(): Response
    {
        return $this->render('pages/status/to_be_reanalysed.html.twig');
    }


    /**
     * @Route("/manager_analysis", name="app-manager-view")
     * @return Response
     */
    public function managerAnalysis(): Response
    {
        return $this->render('pages/status/manager_analysis.html.twig');
    }



}
