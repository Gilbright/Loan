<?php

namespace App\Controller;

use App\Helper\UploaderHelper;
use App\Service\EmployeeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
             return $this->redirectToRoute('admin');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login_demo.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/employee/account", name="app_account")
     */
    public function account(UploaderHelper $uploaderHelper): Response
    {
        return $this->render('pages/account.html.twig',
            [
                'user' => $this->getUser(),
                'imageUrl' => 'Demonstration/account-60a8e3095ecdf.png'
            ]
        );
    }

    /**
     * @Route("/employee/account-updates", name="app_account_updates")
     * @param Request $request
     * @param EmployeeManager $employeeManager
     * @return Response
     */
    public function accountUpdates(Request $request, EmployeeManager $employeeManager): Response
    {
        if ($request->isMethod('POST')){
            $employeeManager->updateUserInfos($request->request->all(), $this->getUser());

            return $this->redirectToRoute('app_account');
        }

        return $this->render('forms/update_empoyee_infos.html.twig', ['user' => $this->getUser()]);
    }
}
