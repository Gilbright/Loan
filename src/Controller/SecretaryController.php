<?php

namespace App\Controller;

use App\Service\ClientManager;
use App\Service\OptionsResolver\ProjectResolver;
use App\Service\ProjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecretaryController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminGo(): Response
    {
        return $this->render('pages/dashboard.html.twig');
    }

    /**
     * @Route("/secretary/registerProject", name="app_sec_register_project")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function index(Request $request, ProjectManager $projectManager): Response
    {
        if ($request->isMethod('POST')){
            $projectManager->execute($request->request->all());

            return $this->redirectToRoute('app_sec_list_client');
        }

        return $this->render('forms/register_project.html.twig');
    }

    /**
     * @Route("/secretary/waintingControl", name="app_sec_waiting_control")
     * @param Request $request
     * @return Response
     */
    public function secWaitingControl (Request $request): Response
    {
        return $this->render('pages/status/sec_waiting_for_control.html.twig');
    }

    /**
     * @Route("/secretary/clients}", name="app_sec_list_client")
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function listClient(ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        $clients = $clientManager->getClients($projectManager->getProjectId());

        return $this->render('forms/registered_clients_infos.html.twig',[
            'clientsData' => $clients
        ]);
    }

    /**
     * @Route("/secretary/registerClient", name="app_sec_register_client")
     * @param Request $request
     * @param ClientManager $clientManager
     * @return Response
     */
    public function registerClient(Request $request, ClientManager $clientManager): Response
    {
        if ($request->isMethod('POST')){
             $clientManager->execute($request->request->all());
            return $this->redirectToRoute('app_sec_list_client');
        }

        return $this->render('forms/register_client.html.twig');
    }
}
