<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 28.02.2021
 * Time: 21:20
 */

namespace App\Service;


use App\Entity\Employee;
use App\Entity\FinanceDetail;
use App\Entity\Project;
use App\Helper\TypeHelper;
use App\Repository\ClientRepository;
use App\Repository\FinanceDetailRepository;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\FinancialDetailResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use mysql_xdevapi\Exception;
use Symfony\Component\Security\Core\Security;

class FinanceManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ClientRepository $clientRepository*/
    private $clientRepository;

    /** @var ProjectRepository $projectRepository */
    private $projectRepository;

    /** @var Security $security*/
    private $security;

    /** @var FinanceDetailRepository $financeDetailRepository*/
    private $financeDetailRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     * @param ProjectRepository $projectRepository
     * @param Security $security
     * @param FinanceDetailRepository $financeDetailRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, ProjectRepository $projectRepository, Security $security, FinanceDetailRepository $financeDetailRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->projectRepository = $projectRepository;
        $this->security = $security;
        $this->financeDetailRepository = $financeDetailRepository;
    }

    public function excecute(array $data)
    {
        $data = FinancialDetailResolver::resolve($data);

        /** @var Employee $employee */
        $employee = $this->security->getUser();

        $financeDetail =  new FinanceDetail();
        $project = $data['project'];
        $type = $data['dropdownName'] === 'Entree';

        $financeDetail
            ->setType($type)
            ->setAmount((float)$data['amount'])
            ->setProjectId($project)
            ->setFinanceDetailDocument($data['financeDetailDoc'])
            ->setAmountLeftToBePaidToUs($this->calculateAmountLeftToBePaidToUs($project, (float)$data['amount'], strtolower($data['dropdownName'])))
            ->setAmountLeftToBeSentByUs($this->calculateAmountLeftToBeSentByUs($project, (float)$data['amount'], strtolower($data['dropdownName'])))
            ->setExtra($data['paymentDetails'])
            ->setOperationExecutor($employee)
        ;

        $this->entityManager->persist($financeDetail);
        $this->entityManager->flush();

        return $financeDetail;
    }

    public function getFinancialDetailsByProjectId(string $projectId)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('f')
            ->from(FinanceDetail::class, 'f')
            ->innerJoin('f.projectId', 'p', Join::WITH, 'p.projectId = :projectId')
            ->setParameter('projectId', $projectId)
            ->orderBy('f.createdAt', 'ASC')
            ->getQuery()->getResult();
    }

    /**
     * @param Project $project
     * @param float $amount
     * @param string $type
     * @return float|null
     */
    public function calculateAmountLeftToBePaidToUs(Project $project, float $amount, string $type): ?float
    {
        /** @var FinanceDetail $financialDetail*/
        $financialDetails = $this->getProjectByType($project->getProjectId(), TypeHelper::TYPE_PARSER['entree']);

        $amountTotal = 0;

        if ($type === TypeHelper::ENTREE){
            $amountTotal = $amount;
        }

        if ($financialDetails){
            foreach ($financialDetails as $financialDetail){
                $amountTotal += $financialDetail->getAmount();
            }
        }

        return $project->getFinalAmount() - $amountTotal;
    }

    /**
     * @param Project $project
     * @param float $amount
     * @param string $type
     * @return float|null
     */
    public function calculateAmountLeftToBeSentByUs(Project $project, float $amount, string $type): ?float
    {
        /** @var FinanceDetail $financialDetail*/
        $financialDetails = $this->getProjectByType($project->getProjectId(), TypeHelper::TYPE_PARSER['sortie']);

        $amountTotal = 0;

        if ($type === TypeHelper::SORTIE) {
            $amountTotal = $amount;
        }

        if ($financialDetails){

            foreach ($financialDetails as $financialDetail){
                $amountTotal += $financialDetail->getAmount();
            }

        }

        return $project->getFinalAmount() - $amountTotal;
    }

    /**
     * @param string $projectId
     * @param bool $type
     * @return array
     */
    public function getProjectByType(string $projectId, bool $type): array
    {
        $financialDetails = $this->getFinancialDetailsByProjectId($projectId);

        $financialDetailsByType = [];

        /** @var FinanceDetail $financialDetail*/
        foreach ($financialDetails as $financialDetail){
            if ($financialDetail->getType() === $type){
                $financialDetailsByType[] = $financialDetail;
            }
        }

        return $financialDetailsByType;
    }

    public function getFinanceReportInDateRange(\DateTime $startDate, \DateTime $endDate){
        $newEndDate = $endDate->modify('+1 day');

        return $this->financeDetailRepository->createQueryBuilder('f')
            ->andWhere('f.updatedAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $newEndDate)
            ->getQuery()
            ->getResult();
    }


    public function getFinancialDetails(): array
    {
        try {
            return $this->financeDetailRepository->findBy([], ['updatedAt' => 'DESC']);
        }catch (\Throwable $exception){
            return [];
        }
    }
}