<?php


namespace App\Service;


use App\Entity\Project;
use App\Helper\Status;
use App\Service\OptionsResolver\ProjectResolver;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    private $projectId;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(array $data): void
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
            ->setName($data['projectName']);

       /* $this->entityManager->persist($projectEntity);
        $this->entityManager->flush();*/

        $this->projectId = $projectEntity->getProjectId();
    }

    private function repaymentDurationCalculator(array $data): float
    {
        $monthlyPay = $data['modalityAmount'] / $data['modalityNumberOfMonths'];

        return $data['amountWanted'] / $monthlyPay;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId($projectId): void
    {
        $this->projectId = $projectId;
    }
}