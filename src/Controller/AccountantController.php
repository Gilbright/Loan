<?php

namespace App\Controller;

use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\FinanceManager;
use App\Service\NoteManager;
use App\Service\ProjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountantController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_ACCOUNTANT')")
 */
class AccountantController extends AbstractController
{
    /**
     * @Route("/accountant/waitingConfirmation", name="app_acc_waiting_finance")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accWaitingForFinance(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_BEEN_VALIDATED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/acc_waiting_finance.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/accountant/view/{projectId}", name="app_acc_view")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param string $projectId
     * @param Request $request
     * @param NoteManager $noteManager
     * @param FinanceManager $financeManager
     * @return Response
     */
    public function accView(ProjectManager $projectManager, ClientManager $clientManager, string $projectId, Request $request, NoteManager $noteManager, FinanceManager $financeManager): Response
    {
        $project = $projectManager->getProjectById($projectId);
        $projectTeam = $clientManager->getClients($projectId);
        $projectNotes = $noteManager->getNotesByProjectId($projectId);
        $financialDetails = $financeManager->getFinancialDetailsByProjectId($projectId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $project;
            if (isset($data['noteContent'])){
                $noteManager->execute($data);
            } elseif (isset($data['paymentDetails'])) {
                $projectManager->changeProjectStatus(Status::ACC_VALIDATED_FINANCED, $projectId);
                $financeManager->excecute($data);
            }

            return $this->redirectToRoute('app_acc_view', ['projectId' => $projectId]);
        }

        return $this->render('pages/statusRedirections/accountant_view.html.twig', [
            'project' => $project,
            'projectTeam' => $projectTeam,
            'projectNotes' => $projectNotes,
            'financeDetails' => $financialDetails
        ]);
    }

    /**
     * @Route("/acc/ValidatedFinanced", name="app_acc_validated_financed")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accValidatedFinanced(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_VALIDATED_FINANCED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/acc_validated_financed.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/acc/accListLacFund", name="app_acc_list_lac_fund")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accListLacFund(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_LACKING_FUND);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/acc_lacking_fund.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/accountant/accLacFund/{projectId}", name="acc_lack_fund")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function accLackFund(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::ACC_LACKING_FUND, $projectId);
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/accountant/financialReport", name="app_acc_report")
     * @param ProjectManager $projectManager
     */
    public function accFinancialReport(ProjectManager $projectManager, FinanceManager $financeManager)
    {
        $financialDetails = $financeManager->getFinancialDetails();

        return $this->render('tables/financial_report.html.twig', [
            'financialDetails' => $financialDetails
        ]);
    }
}
