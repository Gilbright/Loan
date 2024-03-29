<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Project;
use App\Entity\ProjectMaster;
use App\Helper\MailReceiverHelper;
use App\Helper\Status;
use App\Helper\UploaderHelper;
use App\Repository\ProjectMasterRepository;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ProjectResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class ProjectManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;


    /**@var ProjectMasterRepository */
    private $projectMasterRepository;

    /**@var ProjectRepository */
    private $projectRepository;

    /**@var EmployeeManager $employeeManager */
    private $employeeManager;

    /**
     * @var MailerManager $mailerManager
     */
    private $mailerManager;

    /** @var ClientManager */
    private ClientManager $clientManager;

    private UploaderHelper $uploaderHelper;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProjectMasterRepository $projectMasterRepository
     * @param EmployeeManager $employeeManager
     * @param MailerManager $mailerManager
     * @param ClientManager $clientManager
     * @param ProjectRepository $projectRepository
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ProjectMasterRepository $projectMasterRepository,
        EmployeeManager $employeeManager,
        MailerManager $mailerManager,
        ClientManager $clientManager,
        ProjectRepository $projectRepository,
        UploaderHelper $uploaderHelper
    )
    {
        $this->entityManager = $entityManager;
        $this->projectMasterRepository = $projectMasterRepository;
        $this->employeeManager = $employeeManager;
        $this->mailerManager = $mailerManager;
        $this->clientManager = $clientManager;
        $this->projectRepository = $projectRepository;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function execute(array $data): ?string
    {
        $data = ProjectResolver::resolve($data);

        $requestId = str_replace('.', '', uniqid('ph_', false));

        $businessPlanDoc = $this->uploaderHelper->uploadPhenixFile($data['businessPlanDoc'], $requestId.UploaderHelper::BUS_PLAN_DOC_NAME);
        $detailsExtraDoc = $this->uploaderHelper->uploadPhenixFile($data['detailsExtraDoc'], $requestId.UploaderHelper::DET_EXTRA_DOC_NAME);

        $projectEntity = (new Project())
            ->setStatus(Status::EXP_WAITING_FOR_ANALYSIS)
            ->setRepaymentDuration((int)$this->repaymentDurationCalculator($data))
            ->setModalityPaymentFrequency((int)$data['modalityNumberOfMonths']) //TODO revoir le hesaplama RepaymentDuration is in months
            ->setModalityAmount((int)$data['modalityAmount'])
            ->setAmount((int)$data['amountWanted'])
            ->setFinalAmount(0)
            ->setBusinessPlanDocUrl($businessPlanDoc)
            ->setDetailsExtraDocUrl($detailsExtraDoc)
            ->setName($data['projectName'])
            ->setDetails($data['projectDetails'])
        ;

        $projectMaster = (new ProjectMaster())
            ->setRequestId($requestId)
            ->setIsAbandoned(false)
            ->setProject($projectEntity)
            ->setIsFinished(false)
        ;

        $this->entityManager->persist($projectMaster);
        $this->entityManager->flush();

        return $projectMaster->getRequestId();
    }

    public function repaymentDurationCalculator(array $data): int
    {
        $monthlyPay = $data['modalityAmount'] / $data['modalityNumberOfMonths'];

        $result = ceil($data['amountWanted'] / $monthlyPay);

        return $result > 24 ? 25 : $result;
    }

    public function getProjectsByStatus(string $status): array
    {
        return $this->projectRepository->findBy(
            ['status' => $status],
            ['createdAt' => 'DESC']
        );
    }

    public function getProjectsInDateRangeByStatus(string $status, \DateTime $startDate, \DateTime $endDate)
    {
        return $this->projectRepository->createQueryBuilder('p')
            ->andWhere('p.status = :status')
            ->setParameter('status', $status)
            ->andWhere('p.updatedAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getResult();
    }

    public function removeProjectWithoutClient(array $projects): array
    {
        $projectsArray = [];
        /** @var Project $project */
        foreach ($projects as $project) {
            if (!$project->getProjectMaster()->getClients()->isEmpty()) {
                $projectsArray[] = $project;
            }
        }

        return $projectsArray;
    }

    public function listProjectsByDates(Request $request, string $status): ?array
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);
            $endDate = $endDate->modify('+1 day');

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $projectsInRange = $this->getProjectsInDateRangeByStatus($status, $startDate, $endDate);
            $projects = $this->removeProjectWithoutClient($projectsInRange);

            $teamLeads = $this->clientManager->getProjectsTeamLeads($projects);

            return [
                'projects'  => $projects,
                'teamLeads' => $teamLeads
            ];
        }

        return null;
    }

    public function getProjectMasterById(string $requestId = null): ?ProjectMaster
    {
        $projectMaster = $this->projectMasterRepository->findOneBy(['requestId' => $requestId]);

        if (!$projectMaster instanceof ProjectMaster) {
            throw new EntityNotFoundException("Il n'existe pas de projet concordant avec ce identifiant! Veuillez corriger."); // update this message
        }

        return $projectMaster;
    }

    public function changeProjectStatus(string $newStatus, string $requestId)
    {
        /** @var ProjectMaster $projectMaster */
        $projectMaster = $this->getProjectMasterById($requestId);

        $this->changeProjectStatusByProjectMaster($projectMaster, $newStatus);
    }

    public function changeProjectStatusByProjectMaster(ProjectMaster $projectMaster, string $newStatus)
    {
        $mailReceivers = MailReceiverHelper::getReceiverRoleByStatus($newStatus);

        $projectMaster->getProject()->setStatus($newStatus);

        if ($newStatus === Status::PROJECT_COMPLETED){
            $projectMaster
                ->setIsFinished(true)
                ->setEndDate(new \DateTime())
            ;
        }

        // if that status change is concerned by an update mail sending, then we do it here.
        if ($mailReceivers) {
            foreach ($mailReceivers as $receiver) {
                $users = $this->employeeManager->getUsersByRole($receiver);

                foreach ($users as $user) {
                    $this->mailerManager->sendMailNotification($projectMaster, $user);
                }
            }
        }

        $this->entityManager->flush();
    }

    public function setTeamLeadDoc(Client $client, $requestId)
    {
        foreach ($client->getProjectMasters() as $projectMaster) {
            if ($projectMaster->getRequestId() === $requestId) {
                $projectMaster->setTeamLeadDocId($client->getIdDocNumber());
                $client->setIsTeamLead(true);
            }
        }

        $this->entityManager->flush();
    }

    public function doFlush()
    {
        $this->entityManager->flush();
    }
}