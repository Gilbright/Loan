<?php

namespace App\Controller;

use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\EmployeeManager;
use App\Service\FinanceManager;
use App\Service\NoteManager;
use App\Service\ProjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BossController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_BOSS')")
 */
class BossController extends AbstractController
{
    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!******* TODO !!!!

    /**
     * @Route("/boss/waitingConfirmation", name="app_boss_waiting_confirmation")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossWaitingConfirmation(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_MANAGER_ANALYSIS);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_manager_analysis.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/view/{projectId}", name="app_boss_view")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param string $projectId
     * @param Request $request
     * @param NoteManager $noteManager
     * @param FinanceManager $financeManager
     * @return Response
     */
    public function bossView(ProjectManager $projectManager, ClientManager $clientManager, string $projectId, Request $request, NoteManager $noteManager, FinanceManager $financeManager): Response
    {
        $project = $projectManager->getProjectById($projectId);
        $projectTeam = $clientManager->getClients($projectId);
        $projectNotes = $noteManager->getNotesByProjectId($projectId);
        $financialDetails = $financeManager->getFinancialDetailsByProjectId($projectId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $project;

            $noteManager->execute($data);

            return $this->redirectToRoute('app_boss_view', ['projectId' => $projectId]);
        }

        return $this->render('pages/statusRedirections/boss_view.html.twig', [
            'project' => $project,
            'projectTeam' => $projectTeam,
            'projectNotes' => $projectNotes,
            'financeDetails' => $financialDetails
        ]);
    }


    /**
     * @Route ("/boss/validateForFinance/{projectId}", name="boss_validate_for_finance")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossValidateForFinance(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::BOS_BEEN_VALIDATED, $projectId);
        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route ("/boss/continueLater/{projectId}", name="boss_continue_later")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossContinueLater(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::BOS_MANAGER_ANALYSIS_GOING_ON, $projectId);
        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route ("/boss/rejectProject/{projectId}", name="boss_reject_project")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossRejectForReview(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::BOS_TO_BE_REANALYZED, $projectId);
        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route("/boss/analysisGoingOn", name="app_boss_analysis_going_on")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossAnalysisOn(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_MANAGER_ANALYSIS_GOING_ON);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('/pages/status/bos_analysis_going_on.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/beenValidated", name="app_boss_been_validated")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossBeenValidated(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_BEEN_VALIDATED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_been_validated.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/validatedFinanced", name="app_boss_validated_financed")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossValidatedFinanced(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_VALIDATED_FINANCED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_validated_financed.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/validatedLacking", name="app_boss_validated_lacking")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossValidatedLacking(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_LACKING_FUND);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_lacking_fund.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/toReview", name="app_boss_to_review")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossToReview(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_TO_BE_REANALYZED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_to_be_reanalysed.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/rejectedProjects", name="app_boss_rejected_projects")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossRejectedProjects(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::EXP_REJECTED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/exp_rejected.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/boss/resendToExpert/{projectId}", name="boss_resend_to_expert")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossResendToExpert(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_WAITING_FOR_ANALYSIS, $projectId);
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/boss/fullReject/{projectId}", name="boss_full_reject")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossFullReject(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_REJECTED, $projectId);
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/boss/newEmployee", name="app_boss_add_employee")
     * @param Request $request
     * @param EmployeeManager $employeeManager
     */
    public function bossAddEmployee(Request $request, EmployeeManager $employeeManager)
    {
        if ($request->isMethod('POST')) {
            $employeeManager->execute($request->request->all());
            return $this->redirectToRoute('boss_list_employees');
        }

        return $this->render('forms/register_employee.html.twig');
    }

    /**
     * @Route ("/boss/listEmployee", name="boss_list_employees")
     * @param EmployeeManager $employeeManager
     * @return Response
     */
    public function bossGetEmployees(EmployeeManager $employeeManager): Response
    {
        $employees = $employeeManager->getEmployees();
        return $this->render('forms/registered_employees.html.twig', ['employeesData' => $employees]);
    }






    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!*******
    // TODO !!!! add is GRANTED authorisation per controller accordingly to employee type.

}
