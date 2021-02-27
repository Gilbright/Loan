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















    //TODO: The BOSS must add a note before validating or rejecting any project !!!!!******* TODO !!!!

}
