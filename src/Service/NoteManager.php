<?php


namespace App\Service;


use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Security\Core\Security;

class NoteManager
{
    /**
     * @var NoteRepository $noteRepository
     */
    private $noteRepository;

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var Security $security
     */
    private $security;

    /**
     * NoteManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param NoteRepository $noteRepository
     */
    public function __construct(EntityManagerInterface $entityManager, NoteRepository $noteRepository, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->noteRepository = $noteRepository;
        $this->security = $security;
    }

    public function execute (array $data){
        $content = $data['noteContent'];
        $employee = $this->security->getUser();

        $noteEntity = (new Note())
            ->setContent($content)
            ->setEmployee($employee)
            ->setProject($data['project']);

        $this->entityManager->persist($noteEntity);
        $this->entityManager->flush();
    }

    public function getNotesByProjectId(string $projectId){
        $result = $this->entityManager->createQueryBuilder()
            ->select('n')
            ->from(Note::class, 'n')
            ->innerJoin('n.project', 'p', Join::WITH, 'p.projectId = :projectId')
            ->setParameter('projectId', $projectId)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()->getResult();

        return $result;
    }
}