<?php

namespace App\Controller;

use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\NoteManager;
use App\Service\ProjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BossController extends AbstractController
{
    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!******* TODO !!!!

    /**
     * @Route("/boss/waitingConfirmation", name="app_boss_waiting_confirmation")
     * @param Request $request
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
     * @return Response
     */
    public function bossView(ProjectManager $projectManager, ClientManager $clientManager, string $projectId, Request $request, NoteManager $noteManager): Response
    {
        $project = $projectManager->getProjectById($projectId);
        $projectTeam = $clientManager->getClients($projectId);
        $projectNotes = $noteManager->getNotesByProjectId($projectId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $project;

            $noteManager->execute($data);

            return $this->redirectToRoute('app_boss_view', ['projectId' => $projectId]);
        }

        return $this->render('pages/statusRedirections/boss_view.html.twig', [
            'project' => $project,
            'projectTeam' => $projectTeam,
            'projectNotes' => $projectNotes
        ]);
    }

    /**
     * @Route ("/boss/validateForFinance/{projectId}", name="boss_validate_for_finance")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function bossValidateForFinance (string $projectId, ProjectManager $projectManager)
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
    public function bossRejectForReview (string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::BOS_TO_BE_REANALYZED, $projectId);
        return $this->redirectToRoute('app_boss_waiting_confirmation');
    }

    /**
     * @Route("/boss/analysisGoingOn", name="app_boss_analysis_going_on")
     * @param Request $request
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
     * @param Request $request
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
     * @param Request $request
     * @return Response
     */
    public function bossValidatedFinanced (ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_VALIDATED_FINANCED);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/acc_validated_financed.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/validatedLacking", name="app_boss_validated_lacking")
     * @param Request $request
     * @return Response
     */
    public function bossValidatedLacking (ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::ACC_LACKING_FUND);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/acc_lacking_fund.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/boss/toReview", name="app_boss_to_review")
     * @param Request $request
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
     * @param Request $request
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













    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!*******
    // TODO !!!! add is GRANTED authorisation per controller accordingly to employee type.

}
