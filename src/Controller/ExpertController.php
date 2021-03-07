<?php

namespace App\Controller;

use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\NoteManager;
use App\Service\ProjectManager;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/expert/waitingAnalysis", name="app_exp_waiting_analysis")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expWaitingAnalysis(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::EXP_WAITING_FOR_ANALYSIS);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/exp_waiting_for_analysis.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }


    /**
     * @Route("/expert/view/{projectId}", name="app_expert_view")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param string $projectId
     * @param Request $request
     * @param NoteManager $noteManager
     * @return Response
     */
    public function expertView(ProjectManager $projectManager, ClientManager $clientManager, string $projectId, Request $request, NoteManager $noteManager, EntityManagerInterface $entityManager): Response
    {
        $project = $projectManager->getProjectById($projectId);
        $projectTeam = $clientManager->getClients($projectId);
        $projectNotes = $noteManager->getNotesByProjectId($projectId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $project;

            if (isset($data['noteContent'])){
                $noteManager->execute($data);
            }elseif (isset($data['finalAmount'])) {
                $project->setFinalAmount((float) $data['finalAmount']);

                $entityManager->flush();
            }


            return $this->redirectToRoute('app_expert_view', ['projectId' => $projectId]);
        }
        return $this->render('pages/statusRedirections/expert_view.html.twig', [
            'project' => $project,
            'projectTeam' => $projectTeam,
            'projectNotes' => $projectNotes,
            'financeDetails' => []
        ]);
    }

    /**
     * @Route ("/expert/sendToInterview/{projectId}", name="expert_send_to_interview")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function sendToInterview(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_INTERVIEW_STEP, $projectId);
        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/continueLater/{projectId}", name="expert_continue_later")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function expContinueLater(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_ANALYSIS_ON_GOING, $projectId);
        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/rejectProject/{projectId}", name="expert_reject_project")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function expRejectProject(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_REJECTED, $projectId);
        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route("/expert/analysisOnGoing", name="app_exp_analysis_on_going")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expAnalysisOn(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::EXP_ANALYSIS_ON_GOING);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/exp_analysis_on_going.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/interviewStep", name="app_exp_interview_step")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expInterviewStep(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $postInterviewProjects = $projectManager->getProjectsByStatus(Status::EXP_POST_INTERVIEW);
        $projects = $projectManager->getProjectsByStatus(Status::EXP_INTERVIEW_STEP);
        $projects = array_merge($postInterviewProjects, $projects);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/exp_interview_step.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/expert/toReview", name="app_exp_to_review")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function expToReview(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::BOS_TO_BE_REANALYZED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/bos_to_be_reanalysed.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/expert/sendToPostInterview/{projectId}", name="expert_post_interview")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function expPostInterview(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_POST_INTERVIEW, $projectId);
        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    /**
     * @Route ("/expert/validateProject/{projectId}", name="expert_validate_project")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function expValidateProject(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::BOS_MANAGER_ANALYSIS, $projectId);
        return $this->redirectToRoute('app_exp_waiting_analysis');
    }

    //TODO: The expert must add a note before validating or rejecting any project !!!!!******* TODO !!!!

}
