<?php

namespace App\Repository;

use App\Entity\SavingDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SavingDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavingDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavingDetails[]    findAll()
 * @method SavingDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavingDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavingDetails::class);
    }

    // /**
    //  * @return SavingDetails[] Returns an array of SavingDetails objects
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
    public function findOneBySomeField($value): ?SavingDetails
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
