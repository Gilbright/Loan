<?php

namespace App\Controller;

use App\Helper\Status;
use App\Service\ClientManager;
use App\Service\NoteManager;
use App\Service\PaymentManager;
use App\Service\ProjectManager;
use App\Service\SavingManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountantController
 * @package App\Controller
 * @Security("is_granted('ROLE_USER') and is_granted('ROLE_ACCOUNTANT')")
 */
class AccountantController extends AbstractController
{
    /**
     * @Route("/accountant/waitingForFinance", name="app_acc_waiting_finance")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accWaitingForFinance(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::BOS_BEEN_VALIDATED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::BOS_BEEN_VALIDATED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/acc_waiting_finance.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/accountant/view/{requestId}", name="app_acc_view")
     * @param ProjectManager $projectManager
     * @param string $requestId
     * @param Request $request
     * @param NoteManager $noteManager
     * @param PaymentManager $paymentManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function accView(ProjectManager $projectManager, string $requestId, Request $request, NoteManager $noteManager, PaymentManager $paymentManager): Response
    {
        $projectMaster = $projectManager->getProjectMasterById($requestId);

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $data['project'] = $projectMaster->getProject();

            if (isset($data['noteContent'])) {
                $noteManager->execute($data);
            } elseif (isset($data['paymentDetails'])) {
                $projectManager->changeProjectStatus(Status::ACC_VALIDATED_FINANCED, $requestId);

                $paymentManager->excecute($data);

                if (
                    0.0 === round($paymentManager->calculateAmountToReceive($projectMaster), 2)
                    &&
                    0.0 === round($paymentManager->calculateAmountToSend($projectMaster, 2))
                ) {
                    $projectManager->changeProjectStatus(Status::PROJECT_COMPLETED, $requestId);
                }
            }

            return $this->redirectToRoute('app_acc_view', ['requestId' => $requestId]);
        }

        return $this->render('pages/statusRedirections/accountant_view.html.twig', [
            'project'       => $projectMaster->getProject(),
            'projectTeam'   => $projectMaster->getClients(),
            'projectNotes'  => $projectMaster->getProject()->getNotes(),
            'financeDetails' => $projectMaster->getPaymentDetails()
        ]);
    }

    /**
     * @Route("/accountant/ValidatedFinanced", name="app_acc_validated_financed")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accValidatedFinanced(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::ACC_VALIDATED_FINANCED)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::ACC_VALIDATED_FINANCED));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/acc_validated_financed.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route("/accountant/accListLacFund", name="app_acc_list_lac_fund")
     * @param Request $request
     * @param ProjectManager $projectManager
     * @param ClientManager $clientManager
     * @return Response
     */
    public function accListLacFund(Request $request, ProjectManager $projectManager, ClientManager $clientManager): Response
    {
        if ($arrResult = $projectManager->listProjectsByDates($request, Status::ACC_LACKING_FUND)) {
            $projects  = $arrResult['projects'];
            $teamLeads = $arrResult['teamLeads'];
        } else {
            $projects  = $projectManager->removeProjectWithoutClient($projectManager->getProjectsByStatus(Status::ACC_LACKING_FUND));
            $teamLeads = $clientManager->getProjectsTeamLeads($projects);
        }

        return $this->render('pages/status/acc_lacking_fund.html.twig', [
            'projects'  => $projects,
            'teamLeads' => $teamLeads
        ]);
    }

    /**
     * @Route ("/accountant/accLacFund/{requestId}", name="acc_lack_fund")
     * @param string $requestId
     * @param ProjectManager $projectManager
     * @return Response
     */
    public function accLackFund(string $requestId, ProjectManager $projectManager): Response
    {
        $projectManager->changeProjectStatus(Status::ACC_LACKING_FUND, $requestId);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route ("/accountant/financialReport", name="app_acc_report")
     * @param Request $request
     * @param PaymentManager $paymentManager
     * @return Response
     * @throws \Exception
     */
    public function accFinancialReport(Request $request, PaymentManager $paymentManager): Response
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $paymentDetails = $paymentManager->getPaymentDetailsInDateRange($startDate, $endDate);
        } else {
            $paymentDetails = $paymentManager->getAllPaymentDetailsDetails();
        }

        return $this->render('tables/financial_report.html.twig', [
            'financialDetails' => $paymentDetails
        ]);
    }

    /**
     * @Route ("/accountant/savingReport", name="app_acc_saving_report")
     * @param Request $request
     * @param SavingManager $savingManager
     * @return Response
     * @throws \Exception
     */
    public function accSavingReport(Request $request, SavingManager $savingManager): Response
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $savingDetails = $savingManager->getSavingInDateRange($startDate, $endDate);
        } else {
            $savingDetails = $savingManager->getAllSavingDetails();
        }

        return $this->render('tables/saving_report.html.twig', [
            'savingDetails' => $savingDetails
        ]);
    }

    /**
     * @Route ("/accountant/savingAction", name="app_acc_saving_action")
     * @param Request $request
     * @param SavingManager $savingManager
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function accSavingAction(Request $request, SavingManager $savingManager): Response
    {
        if ($request->isMethod('POST')) {
            $savingArray = $request->request->all();
            $savingManager->addSaving($savingArray);

            return $this->redirectToRoute('admin');
        }

        return $this->render('forms/register_saving_operation.html.twig');
    }
}
