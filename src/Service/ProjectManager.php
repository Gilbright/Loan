<?php


namespace App\Service;


use App\Entity\Employee;
use App\Entity\Project;
use App\Helper\MailReceiverHelper;
use App\Helper\Status;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ProjectResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

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

        $projectId = str_replace('.', '', uniqid('ph', false));

        $projectEntity->setProjectId($projectId)
            ->setStatus(Status::EXP_WAITING_FOR_ANALYSIS)
            ->setRepaymentDuration((int)$this->repaymentDurationCalculator($data))

            //TODO revoir le hesaplama RepaymentDuration is in months
            ->setModalityPaymentFrequency((int)$data['modalityNumberOfMonths'])
            ->setModalityAmount((float)$data['modalityAmount'])
            ->setAmount((float)$data['amountWanted'])
            ->setFinalAmount(0)
            ->setIsFinished(false)
            ->setName($data['projectName'])
            ->setDetails($data['projectDetails']);

        $this->entityManager->persist($projectEntity);
        $this->entityManager->flush();

        return $projectEntity->getProjectId();
    }

    private function repaymentDurationCalculator(array $data): float
    {
        $monthlyPay = $data['modalityAmount'] / $data['modalityNumberOfMonths'];

        $result = $data['amountWanted'] / $monthlyPay;
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

    public function removeProjectWithoutClient(array $projects)
    {
        $projectsArray = [];
        /** @var Project $project */
        foreach ($projects as $project) {
            if (!$project->getClients()->isEmpty()) {
                $projectsArray[] = $project;
            }
        }

        return $projectsArray;
    }

    public function listProjectsByDates(Request $request, string $status, ProjectManager $projectManager, ClientManager $clientManager)
    {
        if ($request->isMethod('POST')) {
            $startDate = new \DateTime($request->request->all()['startDate']);
            $endDate = new \DateTime($request->request->all()['endDate']);
            $endDate = $endDate->modify('+1 day');

            if ($endDate < $startDate) {
                throw new Exception("la date finale ne peut pas preceder la date initiale");
            }

            $projects = $projectManager->getProjectsInDateRangeByStatus($status, $startDate, $endDate);
            $projects = $projectManager->removeProjectWithoutClient($projects);

            $teamLeads = $clientManager->getProjectsTeamLeads($projects);

            return [$projects, $teamLeads];
        }

        return null;
    }

    public function getProjectById(string $projectId = null): ?Project
    {
        $project = $this->projectRepository->findOneBy(['projectId' => $projectId]);

        if (!$project instanceof Project) {
            throw new EntityNotFoundException("Il n'exite pas de projet concordant avec ce identifiant! Veuillez corriger.");
        }
        return $project;
    }

    public function changeProjectStatus(string $newStatus, string $projectId)
    {
        /** @var Project $project */
        $project = $this->getProjectById($projectId);

        $mailReceivers = MailReceiverHelper::getReceiverRoleByStatus($newStatus);

        $project->setStatus($newStatus);

        // if that status change is concerned by an update mail sending, then we do it here.
        if ($mailReceivers) {
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