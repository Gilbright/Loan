<?php

namespace App\Controller;

use App\Entity\Client;
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
 * Class SecretaryController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_SECRETARY')")
 */
class SecretaryController extends AbstractController
{
    /**
     * @Route("/secretary/registerProject", name="app_sec_register_project")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function index(Request $request, ProjectManager $projectManager): Response
    {
        if ($request->isMethod('POST')) {
            $projectId = $projectManager->execute($request->request->all());

            return $this->redirectToRoute('app_sec_list_client', ['projectId' => $projectId]);
        }

        return $this->render('forms/register_project.html.twig');
    }

    /**
     * @Route("/secretary/clients/{projectId}", name="app_sec_list_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @param string $projectId
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function listClient(Request $request, ClientManager $clientManager, string $projectId, EntityManagerInterface $entityManager): Response
    {
        $clients = $clientManager->getClientsByProjectId($projectId);

        if ($request->isMethod('POST')) {
            if (isset($request->request->all()['IdNumber'])){
                $idDocNumber = $request->request->all()['IdNumber'];
                $clientManager->setClientProjectId($idDocNumber, $projectId);

                return $this->redirectToRoute('app_sec_list_client',['projectId' => $projectId]);
            }

            /** @var Client $teamLeadClient */
            $teamLeadClient = $clientManager->getClientById(current($clients)['id']);
            $teamLeadClient->setIsTeamLead(true);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('forms/registered_clients_infos.html.twig', [
            'clientsData' => $clients,
            'projectId' => $projectId
        ]);
    }

    /**
     * @Route("/secretary/waintingControl", name="app_sec_waiting_control")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function secWaitingControl(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::SEC_WAITING_FOR_CONTROL);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/sec_waiting_for_control.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/secretary/addClient", name="app_sec_add_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @return Response
     */
    public function AddClient(Request $request, ClientManager $clientManager): Response
    {
        if ($request->isMethod('POST')) {
            $clientManager->addClient($request->request->all());

            return $this->redirectToRoute('admin');
        }

        return $this->render('forms/register_client.html.twig');
    }

    /**
     * @Route("/secretary/registerClient/{projectId}", name="app_sec_register_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @return Response
     */
    public function registerClient(Request $request, ClientManager $clientManager, string $projectId): Response
    {
        if ($request->isMethod('POST')) {
            $clientManager->execute($request->request->all(), $projectId);
            return $this->redirectToRoute('app_sec_list_client', ['projectId' => $projectId]);
        }

        return $this->render('forms/register_client.html.twig');
    }

    /**
     * @Route("/secretary/view/{projectId}", name="app_sec_view")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param string $projectId
     * @param Request $request
     * @param NoteManager $noteManager
     * @return Response
     */
    public function secView(ProjectManager $projectManager, ClientManager $clientManager, string $projectId, Request $request, NoteManager $noteManager): Response
    {
        $project = $projectManager->getProjectById($projectId);
        $projectTeam = $clientManager->getClientsByProjectId($projectId);
        $projectNotes = $noteManager->getNotesByProjectId($projectId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $project;

            $noteManager->execute($data);

            return $this->redirectToRoute('app_sec_view', ['projectId' => $projectId]);
        }
        return $this->render('pages/statusRedirections/secretary_view.html.twig', [
            'project' => $project,
            'projectTeam' => $projectTeam,
            'projectNotes' => $projectNotes,
            'financeDetails' => []
        ]);
    }

    /**
     * @Route("/secretary/interview", name="app_sec_interview")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function secInterviewStep(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $projects = $projectManager->getProjectsByStatus(Status::EXP_INTERVIEW_STEP);
        $teamLeads = $clientManager->getProjectsTeamLeads($projects);

        return $this->render('pages/status/sec_interview_step.html.twig', [
            'projects' => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/secretary/sendToExpertAnalysis/{projectId}", name="secretary_send_to_exp_analysis")
     * @param string $projectId
     * @param ProjectManager $projectManager
     */
    public function sendToExpertAnalysis(string $projectId, ProjectManager $projectManager)
    {
        $projectManager->changeProjectStatus(Status::EXP_WAITING_FOR_ANALYSIS, $projectId);
        return $this->redirectToRoute('app_sec_waiting_control');
    }
}
