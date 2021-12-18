<?php

namespace App\Repository;

use App\Entity\OperationLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationLog[]    findAll()
 * @method OperationLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationLog::class);
    }

    // /**
    //  * @return OperationLog[] Returns an array of OperationLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperationLog
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}