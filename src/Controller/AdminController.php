<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/mailTemplate", name="mail_template")
     * @return Response
     */
    public function demo(): Response
    {
        return $this->render('/mails/employee_mail.html.twig');
    }

    /**
     * @Route("/attente_ee/{requestId}", name="app-view")
     * @param string|null $requestId
     * @return Response
     */
    public function attente($requestId): Response
    {
       // dd($requestId);
        return $this->render('pages/registered_project_clients.html.twig');
    }

    /**
     * @Route("/attente_control/{requestId}", name="app-view1")
     * @param string|null $requestId
     * @return Response
     */
   /* public function attenteControl($requestId): Response
    {
        return $this->render('pages/status/en_attente_de_control.html.twig');
    }
*/
    /**
     * @Route("/attente_etude/{requestId}", name="app-attente-etude-view")
     * @param string|null $requestId
     * @return Response
     */
    public function attenteEtude($requestId): Response
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
     * @Route("/interview_step...*", name="app-interview-view")
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

    /**
     * @Route("/manager_analysis-on", name="app-manager-on")
     * @return Response
     */
    public function managerAnalysisOnGoing(): Response
    {
        return $this->render('pages/status/analysis_on_going.html.twig');
    }

    /**
     * @Route("/manager_validated", name="app-manager-validated")
     * @return Response
     */
    public function managerValidated(): Response
    {
        return $this->render('pages/status/been_validated.html.twig');
    }

    /**
     * @Route("/manager_view_validated", name="app-manager-view-validated")
     * @return Response
     */
    public function managerViewValidated(): Response
    {
        return $this->render('pages/statusRedirections/boss_view_for_validated.html.twig');
    }

    /**
     * @Route("/manager_view_validated_financed", name="app-manager-view-validated")
     * @return Response
     */
    public function managerViewValidatedFinanced(): Response
    {
        return $this->render('pages/status/acc_validated_financed.html.twig');
    }

    /**
     * @Route("/manager_view_validated_financed_view", name="app-manager-valiated-financed-view")
     * @return Response
     */
    public function managerViewValidatedFinancedView(): Response
    {
        return $this->render('pages/statusRedirections/boss_view_for_validated_financed.html.twig');
    }

    /**
     * @Route("/manager_view_lacking_fund", name="app-manager-lacking")
     * @return Response
     */
    public function managerViewlacking(): Response
    {
        return $this->render('pages/status/lacking_fund.html.twig');
    }

    /**
     * @Route("/manager_financial_report", name="app-manager-financial-report")
     * @return Response
     */
    public function managerFinancialReport(): Response
    {
        return $this->render('tables/financial_report.html.twig');
    }
}
