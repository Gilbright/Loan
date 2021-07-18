<?php


namespace App\Service;


use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

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
     * NoteManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param NoteRepository $noteRepository
     */
    public function __construct(EntityManagerInterface $entityManager, NoteRepository $noteRepository)
    {
        $this->entityManager = $entityManager;
        $this->noteRepository = $noteRepository;
    }

    public function execute(array $data)
    {
        $content = $data['noteContent'];

        if ($content) {
            $noteEntity = (new Note())
                ->setContent($content)
                ->setProject($data['project'])
            ;

            $this->entityManager->persist($noteEntity);
            $this->entityManager->flush();
        }
    }

    public function getNotesByProjectId(string $projectId)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('n')
            ->from(Note::class, 'n')
            ->innerJoin('n.project', 'p', Join::WITH, 'p.projectId = :projectId')
            ->setParameter('projectId', $projectId)
            ->orderBy('n.createdAt', 'ASC')
            ->getQuery()->getResult();
    }
}