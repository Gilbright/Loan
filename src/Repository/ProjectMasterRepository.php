<?php

namespace App\Repository;

use App\Entity\ProjectMaster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectMaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectMaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectMaster[]    findAll()
 * @method ProjectMaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectMasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectMaster::class);
    }

    // /**
    //  * @return ProjectMaster[] Returns an array of ProjectMaster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectMaster
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
