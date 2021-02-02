<?php

namespace App\Repository;

use App\Entity\FinanceDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FinanceDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinanceDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinanceDetail[]    findAll()
 * @method FinanceDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinanceDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinanceDetail::class);
    }

    // /**
    //  * @return FinanceDetail[] Returns an array of FinanceDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinanceDetail
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
