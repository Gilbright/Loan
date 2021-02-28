<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 28.02.2021
 * Time: 21:20
 */

namespace App\Service;


use App\Entity\FinanceDetail;
use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class FinanceManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * @var ClientRepository $clientRepository
     */
    private $clientRepository;

    /** @var ProjectRepository $projectRepository */
    private $projectRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     * @param ProjectRepository $projectRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, ProjectRepository $projectRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->projectRepository = $projectRepository;
    }

    public function excecute()
    {

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
}