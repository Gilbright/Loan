<?php


namespace App\Service;


use App\Entity\Project;
use App\Helper\Status;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ProjectResolver;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;


    /**@var ProjectRepository $projectRepository*/
    private $projectRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ProjectRepository $projectRepository)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
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
            ->setName($data['projectName'])
            ->setDetails($data['projectDetails'])
        ;

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
            [ 'status' => $status],
            ['createdAt' => 'DESC']
        );
    }

    public function getProjectById (string $projectId = null)
    {
        return $this->projectRepository->findOneBy(['projectId' => $projectId]);
    }
}