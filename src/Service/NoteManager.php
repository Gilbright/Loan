<?php


namespace App\Service;

use App\Entity\Note;
use App\Entity\ProjectMaster;
use Doctrine\ORM\EntityManagerInterface;

class NoteManager
{
    private EntityManagerInterface $entityManager;

    private ProjectManager $projectManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ProjectManager $projectManager
     */
    public function __construct(EntityManagerInterface $entityManager, ProjectManager $projectManager)
    {
        $this->entityManager = $entityManager;
        $this->projectManager = $projectManager;
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

    public function getNotesByProjectMaster(ProjectMaster $projectMaster)
    {
        return $projectMaster->getProject()->getNotes();
    }
}