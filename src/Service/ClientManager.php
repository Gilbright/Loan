<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Project;
use App\Helper\Status;
use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ClientResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;

class ClientManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * @var ClientRepository $clientRepository
     */
    private $clientRepository;

    /** @var ProjectRepository $projectRepository */
    private $projectRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     * @param ProjectRepository $projectRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository, ProjectRepository $projectRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->projectRepository = $projectRepository;
    }

    public function execute(array $data, string $projectId): void
    {
        $data = ClientResolver::resolve($data);

        //find the project by projectID
        $projectEntity = $this->getProjectById($projectId);

        $clientEntity = new Client();

        $clientEntity->setProjectId($projectEntity)
            ->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setNameSurname($data['nameSurname'])
            ->setIdDocumentPictureLink("link there")
            ->setIdPictureLink("link here")
            ->setNationality($data['nationality'])
            ->setIsTeamLead(false)
            ->setGender("M") // TODO: THİS İS THE DEFAULT VERSİON TO BE FİXED LATER
            ->setProfession($data['profession'])
            ->setMonthlyIncome($data['monthlyIncome'])
            ->setBirthDate($data['birthDate']);

        $this->entityManager->persist($clientEntity);
        $this->entityManager->flush();

    }

    public function getClients(string $projectId = null): array
    {
        $result = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Client::class, 'c')
            ->innerJoin('c.projectId', 'p', Join::WITH, 'p.projectId = :projectId')
            ->setParameter('projectId', $projectId)
            ->setMaxResults(10)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()->getArrayResult();

        return $result;
    }

    public function getClientById (int $clientId)
    {
        return $this->clientRepository->find($clientId);
    }


    public function getProjectById (string $projectId = null)
    {
        return $this->projectRepository->findOneBy(['projectId' => $projectId]);
    }

    public function getProjectsTeamLeads(array $projects): array
    {
        $teamLeads = [];

        foreach ($projects as $project){
            $teamLeads[] =  $this->clientRepository->findOneBy([
                'projectId' => $project->getId(),
                'isTeamLead' => 1
            ]);
        }

        return $teamLeads;
    }
}