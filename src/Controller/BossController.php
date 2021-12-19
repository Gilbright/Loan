<?php

namespace App\Controller;

use App\Helper\Status;
use App\Helper\UploaderHelper;
use App\Service\ClientManager;
use App\Service\EmployeeManager;
use App\Service\NoteManager;
use App\Service\PaymentManager;
use App\Service\ProjectManager;
use App\Service\SavingManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BossController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_BOSS')")
 */
class BossController extends AbstractController
{
    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!******* TODO !!!!
    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!******* TODO !!!!
    //TODO !!!! add is GRANTED authorisation per controller accordingly to employee type.

    /**
     * @Route("/boss/waitingConfirmation", name="app_boss_waiting_confirmation")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossWaitingConfirmation(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_MANAGER_ANALYSIS)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_MANAGER_ANALYSIS));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/bos_manager_analysis.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/view/{requestId}", name="app_boss_view")
     * @param ProjectManager $projectManager
     * @param string $requestId
     * @param Request $request
     * @param NoteManager $noteManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function bossView(ProjectManager $projectManager, string $requestId, Request $request, NoteManager $noteManager): Response
    {
        $projectMaster = $projectManager->getProjectMasterById($requestId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $projectMaster->getProject();

            $noteManager->execute($data);

            return $this->redirectToRoute('app_boss_view', ['requestId' => $requestId]);
        }

        return $this->render('pages/statusRedirections/boss_view.html.twig', [
            'project'       => $projectMaster->getProject(),
            'projectTeam'   => $projectMaster->getClients(),
            'projectNotes'  => $projectMaster->getProject()->getNotes(),
            'financeDetails' => $projectMaster->getPaymentDetails()
        ]);
    }


    /**
     * @Route("/boss/validateForFinance/{requestId}", name="boss_validate_for_finance")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function bossValidateForFinance(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::BOS_BEEN_VALIDATED, $requestId);

        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route("/boss/continueLater/{requestId}", name="boss_continue_later")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function bossContinueLater(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::BOS_MANAGER_ANALYSIS_GOING_ON, $requestId);

        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route ("/boss/rejectProject/{requestId}", name="boss_reject_project")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function bossRejectForReview(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::BOS_TO_BE_REANALYZED, $requestId);

        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route("/boss/analysisGoingOn", name="app_boss_analysis_going_on")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossAnalysisOn(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_MANAGER_ANALYSIS_GOING_ON)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_MANAGER_ANALYSIS_GOING_ON));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('/pages/status/bos_analysis_going_on.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/beenValidated", name="app_boss_been_validated")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossBeenValidated(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_BEEN_VALIDATED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_BEEN_VALIDATED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/bos_been_validated.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/validatedFinanced", name="app_boss_validated_financed")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossValidatedFinanced(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::ACC_VALIDATED_FINANCED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::ACC_VALIDATED_FINANCED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/bos_validated_financed.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/validatedLacking", name="app_boss_validated_lacking")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossValidatedLacking(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::ACC_LACKING_FUND)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::ACC_LACKING_FUND));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/bos_lacking_fund.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/toReview", name="app_boss_to_review")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossToReview(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_TO_BE_REANALYZED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_TO_BE_REANALYZED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/bos_to_be_reanalysed.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/rejectedProjects", name="app_boss_rejected_projects")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossRejectedProjects(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::EXP_REJECTED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::EXP_REJECTED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_rejected.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/boss/completedProjects", name="app_boss_completed_projects")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function bossCompletedProjects(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::PROJECT_COMPLETED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::PROJECT_COMPLETED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_rejected.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/boss/resendToExpert/{requestId}", name="boss_resend_to_expert")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function bossResendToExpert(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_WAITING_FOR_ANALYSIS, $requestId);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/boss/fullReject/{requestId}", name="boss_full_reject")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function bossFullReject(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_REJECTED, $requestId);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/boss/newEmployee", name="app_boss_add_employee")
     * @param Request $request
     * @param EmployeeManager $employeeManager
     * @return Response
     */
    public function bossAddEmployee(Request $request, EmployeeManager $employeeManager, UploaderHelper $uploaderHelper)
    {
        if ($request->isMethod('POST')) {
            $data = array_merge($request->files->all(), $request->request->all());

            $employeeManager->execute($data);

            return $this->redirectToRoute('app_boss_list_employees');
        }

        return $this->render('forms/register_employee.html.twig');
    }

    /**
     * @Route ("/boss/listEmployee", name="app_boss_list_employees")
     * @param EmployeeManager $employeeManager
     * @return Response
     */
    public function bossGetEmployees(EmployeeManager $employeeManager): Response
    {
        $users = $employeeManager->getUsers();

        return $this->render('forms/registered_employees.html.twig', ['employeesData' => $users]);
    }

    /**
     * @Route ("/boss/financialReport", name="app_boss_report")
     * @param Request $request
     * @param PaymentManager $paymentManager
     * @return Response
     * @throws \Exception
     */
    public function bossFinancialReport(Request $request, PaymentManager $paymentManager)
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $paymentDetails = $paymentManager->getPaymentDetailsInDateRange($startDate, $endDate);
        } else {
            $paymentDetails = $paymentManager->getAllPaymentDetailsDetails();
        }

        return $this->render('tables/financial_report.html.twig', [
            'financialDetails' => $paymentDetails
        ]);
    }

    /**
     * @Route ("/boss/savingReport", name="app_boss_saving_report")
     * @param Request $request
     * @param SavingManager $savingManager
     * @return Response
     * @throws \Exception
     */
    public function bossSavingReport(Request $request, SavingManager $savingManager): Response
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $savingDetails = $savingManager->getSavingInDateRange($startDate, $endDate);
        } else {
            $savingDetails = $savingManager->getAllSavingDetails();
        }

        return $this->render('tables/saving_report.html.twig', [
            'savingDetails' => $savingDetails
        ]);
    }
}
