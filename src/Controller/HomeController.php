<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 5.03.2021
 * Time: 03:19
 */

namespace App\Controller;


use App\Service\ClientManager;
use App\Service\ProjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER')")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function adminGo(): Response
    {
        return $this->render('pages/dashboard.html.twig');
    }

    /**
     * @Route("/readres", name="app_consult_status")
     * @param ProjectManager $projectManager
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function consultStatus(ProjectManager $projectManager, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $requestId = $request->request->all()['requestId'];

            $projectMaster = $projectManager->getProjectMasterById($requestId);
            $projectTeam    = $projectMaster->getClients();
            $projectNotes   = $projectMaster->getProject()->getNotes();
            $paymentDetails = $projectMaster->getPaymentDetails();

            return $this->render('pages/consult_status.html.twig', [
                'project'       => $projectMaster->getProject(),
                'projectTeam'   => $projectTeam,
                'projectNotes'  => $projectNotes,
                'financeDetails' => $paymentDetails
            ]);
        }

        return $this->render('pages/consult_status.html.twig');
    }

    /**
     * @Route("/readresclient", name="app_consult_status_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function consultStatusClient(Request $request, ClientManager $clientManager): Response
    {
        if ($request->isMethod('POST')) {
            $clientIdNumber = $request->request->all()['clientIdNumber'];

            $client = $clientManager->getClientByIdNumber($clientIdNumber);

            return $this->render('pages/consult_status_client.html.twig', [
                'client'        => $client,
                'projects'      => $clientManager->getClientProjects($client->getProjectMasters()),
                'savingDetails' => $client->getSavingDetails()
            ]);
        }

        return $this->render('pages/consult_status_client.html.twig');
    }
}