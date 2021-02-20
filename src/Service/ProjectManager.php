<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }


}