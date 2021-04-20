<?php

namespace App\Repository;

use App\Entity\SavingDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SavingDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavingDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavingDetail[]    findAll()
 * @method SavingDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavingDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavingDetail::class);
    }

    // /**
    //  * @return SavingDetail[] Returns an array of SavingDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SavingDetail
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
