<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 5.03.2021
 * Time: 03:19
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminGo(): Response
    {
        return $this->render('pages/dashboard.html.twig');
    }

    /**
     * @Route("/readres", name="app_register")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('pages/consult_status.html.twig');
    }
}