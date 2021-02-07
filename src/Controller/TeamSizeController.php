<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamSizeController extends AbstractController
{
    /**
     * @Route("/team", name="app_team")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        #dd($request->isMethod('POST'));
        #$request->request->count()
        if ($request->request->get('select_option'))
        {
            return $this->render('forms/register_project.html.twig', [
                'team_size' => $request->request->get('select_option')
            ]);
        }

        return $this->render('forms/team_size.html.twig');
    }
}
