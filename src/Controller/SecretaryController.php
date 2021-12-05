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
            $requestId = $projectManager->execute($request->request->all());

            return $this->redirectToRoute('app_sec_list_client', ['requestId' => $requestId]);
        }

        return $this->render('forms/register_project.html.twig');
    }

    /**
     * @Route("/secretary/clients/{requestId}", name="app_sec_list_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @param string $requestId
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function listClient(Request $request, ClientManager $clientManager, string $requestId): Response
    {
        $clients = $clientManager->getClientsByRequestId($requestId);

        if ($request->isMethod('POST')) {
            if (isset($request->request->all()['IdNumber'])) {
                $idDocNumber = $request->request->all()['IdNumber'];
                $clientManager->setClientProjectMaster($idDocNumber, $requestId);

                return $this->redirectToRoute('app_sec_list_client', ['requestId' => $requestId]);
            }

            /** @var Client $teamLeadClient */
            $teamLeadClient = $clientManager->getClientById($clients->first()->getId());
            $teamLeadClient->setIsTeamLead(true);

            $clientManager->doFlush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('forms/registered_clients_infos.html.twig', [
            'requestId'   => $requestId,
            'clientsData' => $clients
        ]);
    }

    /**
     * @Route ("/secretary/checkEligibility", name="app_sec_eligibility")
     * @param ClientManager $clientManager
     * @param Request $request
     * @return Response
     */
    public function secEligibilityCheck(ClientManager $clientManager, Request $request): Response
    {

        if ($request->isMethod('POST')) {
            $result = $clientManager->isEligible($request->request->all());

            return $this->render('forms/client_eligibility_form.html.twig', ['isEligible' => $result]);
        }

        return $this->render('forms/client_eligibility_form.html.twig');
    }

    /**
     * @Route("/secretary/waintingControl", name="app_sec_waiting_control")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param Request $request
     * @return Response
     */
    public function secWaitingControl(ProjectManager $projectManager, ClientManager $clientManager, Request $request): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::SEC_WAITING_FOR_CONTROL)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects = $projectManager->getProjectsByStatus(Status::SEC_WAITING_FOR_CONTROL);
            $projects = $projectManager->removeProjectWithoutClient($projects);
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/sec_waiting_for_control.html.twig', [
            'projects'  => $projects,
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
     * @Route("/secretary/view/{requestId}", name="app_sec_view")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param string $requestId
     * @param Request $request
     * @param NoteManager $noteManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function secView(ProjectManager $projectManager, ClientManager $clientManager, string $requestId, Request $request, NoteManager $noteManager): Response
    {
        $projectMaster  = $projectManager->getProjectMasterById($requestId);
        $projectClients = $projectMaster->getClients();
        $projectNotes   = $projectMaster->getProject()->getNotes();

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $projectMaster->getProject();

            $noteManager->execute($data);

            return $this->redirectToRoute('app_sec_view', ['requestId' => $requestId]);
        }
        return $this->render('pages/statusRedirections/secretary_view.html.twig', [
            'project'       => $projectMaster->getProject(),
            'projectTeam'   => $projectClients,
            'projectNotes'  => $projectNotes,
            'financeDetails' => []
        ]);
    }

    /**
     * @Route("/secretary/interview", name="app_sec_interview")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @param Request $request
     * @return Response
     */
    public function secInterviewStep(ProjectManager $projectManager, ClientManager $clientManager, Request $request): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::EXP_INTERVIEW_STEP)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects = $projectManager->getProjectsByStatus(Status::EXP_INTERVIEW_STEP);
            $projects = $projectManager->removeProjectWithoutClient($projects);
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/sec_interview_step.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/secretary/sendToExpertAnalysis/{requestId}", name="secretary_send_to_exp_analysis")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendToExpertAnalysis(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::EXP_WAITING_FOR_ANALYSIS, $requestId);

        return $this->redirectToRoute('app_sec_waiting_control');
    }
}
