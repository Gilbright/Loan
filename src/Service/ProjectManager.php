<?php


namespace App\Service;


use App\Entity\Employee;
use App\Entity\Project;
use App\Helper\MailReceiverHelper;
use App\Helper\Status;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ProjectResolver;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;


    /**@var ProjectRepository $projectRepository */
    private $projectRepository;

    /**@var EmployeeManager $employeeManager */
    private $employeeManager;

    /**
     * @var MailerManager $mailerManager
     */
    private $mailerManager;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     * @param EmployeeManager $employeeManager
     * @param MailerManager $mailerManager
     */
    public function __construct(EntityManagerInterface $entityManager, ProjectRepository $projectRepository, EmployeeManager $employeeManager, MailerManager $mailerManager)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
        $this->employeeManager = $employeeManager;
        $this->mailerManager = $mailerManager;
    }

    public function execute(array $data): ?string
    {
        $data = ProjectResolver::resolve($data);

        $projectEntity = new Project();

        $projectId = str_replace('.', '', uniqid('ph', true));

        $projectEntity->setProjectId($projectId)
            ->setStatus(Status::EXP_WAITING_FOR_ANALYSIS)
            ->setRepaymentDuration((int)$this->repaymentDurationCalculator($data)) // RepaymentDuration is in months
            ->setModalityPaymentFrequency((int)$data['modalityNumberOfMonths'])
            ->setModalityAmount((float)$data['modalityAmount'])
            ->setAmount((float)$data['amountWanted'])
            ->setFinalAmount(0)
            ->setName($data['projectName'])
            ->setDetails($data['projectDetails']);

        $this->entityManager->persist($projectEntity);
        $this->entityManager->flush();

        return $projectEntity->getProjectId();
    }

    private function repaymentDurationCalculator(array $data): float
    {
        $monthlyPay = $data['modalityAmount'] / $data['modalityNumberOfMonths'];

        return $data['amountWanted'] / $monthlyPay;
    }

    public function getProjectsByStatus(string $status): array
    {
        return $this->projectRepository->findBy(
            ['status' => $status],
            ['createdAt' => 'DESC']
        );
    }

    public function getProjectById(string $projectId = null)
    {
        return $this->projectRepository->findOneBy(['projectId' => $projectId]);
    }

    public function changeProjectStatus(string $newStatus, string $projectId)
    {
        /** @var Project $project */
        $project = $this->getProjectById($projectId);

        $mailReceivers = MailReceiverHelper::getReceiverRoleByStatus($newStatus);

        $project->setStatus($newStatus);

        // if that status change is concerned by an update mail sending, then we do it here.
        if ($mailReceivers){
            foreach ($mailReceivers as $receiver) {
                $employees = $this->employeeManager->getEmployeesByRole($receiver);

                foreach ($employees as $employee) {
                    $this->mailerManager->sendMailNotification($project, $employee);
                }
            }
        }

        $this->entityManager->flush();
    }
}