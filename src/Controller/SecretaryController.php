<?php

namespace App\Controller;

use App\Service\OptionsResolver\ProjectResolver;
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
     * @return Response
     */
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')){

            dd(ProjectResolver::resolve($request->request->all()));
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
}
