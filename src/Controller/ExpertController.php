<?php

namespace App\Controller;

use App\Entity\Project;
use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\NoteManager;
use App\Service\ProjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ExpertController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_EXPERT')")
 */
class ExpertController extends AbstractController
{
    //TODO: The expert must add a note before validating or rejecting any project !!!!!******* TODO !!!!
    //TODO: The expert must add a note before validating or rejecting any project !!!!!******* TODO !!!!

    /**
     * @Route("/expert/waitingAnalysis", name="app_exp_waiting_analysis")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expWaitingAnalysis(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::EXP_WAITING_FOR_ANALYSIS)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::EXP_WAITING_FOR_ANALYSIS));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_waiting_for_analysis.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/view/{requestId}", name="app_expert_view")
     * @param ProjectManager $projectManager
     * @param string $requestId
     * @param Request $request
     * @param NoteManager $noteManager
     * @return Response
     * @throws EntityNotFoundException
     */
    public function expertView(ProjectManager $projectManager, string $requestId, Request $request, NoteManager $noteManager): Response
    {
        $projectMaster = $projectManager->getProjectMasterById($requestId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $projectMaster->getProject();

            if (isset($data['noteContent'])) {
                $noteManager->execute($data);
            } elseif (isset($data['finalAmount'])) {
                $project = $projectMaster->getProject();
                $project->setFinalAmount((int)$data['finalAmount']);
                $project->setModalityAmount((int)$data['modalityAmount']);
                $project->setModalityPaymentFrequency((int)$data['modalityNumberOfMonths']);

                $repaymentArray = [
                    'amountWanted'           => (int)$data['finalAmount'],
                    'modalityAmount'         => (int)$data['modalityAmount'],
                    'modalityNumberOfMonths' => (int)$data['modalityNumberOfMonths']
                ];

                $project->setRepaymentDuration($projectManager->repaymentDurationCalculator($repaymentArray));

                $projectManager->doFlush();
            }

            return $this->redirectToRoute('app_expert_view', ['requestId' => $requestId]);
        }

        return $this->render('pages/statusRedirections/expert_view.html.twig', [
            'project'       => $projectMaster->getProject(),
            'projectTeam'   => $projectMaster->getClients(),
            'projectNotes'  => $projectMaster->getProject()->getNotes(),
            'financeDetails' => []
        ]);
    }

    /**
     * @Route ("/expert/sendToInterview/{requestId}", name="expert_send_to_interview")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function sendToInterview(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_INTERVIEW_STEP, $requestId);

        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/continueLater/{requestId}", name="expert_continue_later")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function expContinueLater(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_ANALYSIS_ON_GOING, $requestId);

        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/rejectProject/{requestId}", name="expert_reject_project")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function expRejectProject(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_REJECTED, $requestId);

        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route("/expert/analysisOnGoing", name="app_exp_analysis_on_going")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expAnalysisOn(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::EXP_ANALYSIS_ON_GOING)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::EXP_ANALYSIS_ON_GOING));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_analysis_on_going.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/interviewStep", name="app_exp_interview_step")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expInterviewStep(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $arrInterview = $projectManager->listProjectsByDates($request, Status::EXP_INTERVIEW_STEP);
        $arrPostInterview = $projectManager->listProjectsByDates($request, Status::EXP_POST_INTERVIEW);

        if ($arrPostInterview || $arrInterview) {
            $projects  = array_merge($arrPostInterview['projects'], $arrInterview['projects']);
            $teamLeads = array_merge($arrPostInterview['teamLeads'], $arrInterview['teamLeads']);
        } else {
            $projects = $projectManager->getProjectsByStatus(Status::EXP_INTERVIEW_STEP);
            $postInterviewProjects = $projectManager->getProjectsByStatus(Status::EXP_POST_INTERVIEW);

            $projects  = $projectManager->removeProjectWithoutClient(array_merge($postInterviewProjects, $projects));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_interview_step.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/toReview", name="app_exp_to_review")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expToReview(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_TO_BE_REANALYZED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_TO_BE_REANALYZED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/exp_to_be_reanalysed.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/sendToPostInterview/{requestId}", name="expert_post_interview")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function expPostInterview(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_POST_INTERVIEW, $requestId);

        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/validateProject/{requestId}", name="expert_validate_project")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function expValidateProject(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::BOS_MANAGER_ANALYSIS, $requestId);

        return $this->redirectToRoute('app_exp_waiting_analysis');
    }
}
