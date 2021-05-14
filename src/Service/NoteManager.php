<?php


namespace App\Service;


use App\Entity\Employee;
use App\Entity\Note;
use App\Helper\RoleTranslator;
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

    public function execute(array $data)
    {
        $content = $data['noteContent'];
        if ($content) {
            /** @var Employee $employee */
            $employee = $this->security->getUser();
            $authorRole = current(array_filter($employee->getRoles(), function ($role) {
                return $role !== 'ROLE_USER';
            }));

            $noteEntity = (new Note())
                ->setAuthorRole(RoleTranslator::translate($authorRole))
                ->setContent($content)
                ->setEmployee($employee)
                ->setProject($data['project']);

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