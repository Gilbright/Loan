<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Project;
use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;
use App\Service\OptionsResolver\ClientResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Config\Definition\Exception\Exception;

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

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        //find the project by projectID
        $projectEntity = $this->getProjectById($projectId);

        if (!$projectEntity) {
            //TODO: thow an exception that the project entity has not been found
            throw new EntityNotFoundException("Ce Projet n'existe pas, reverifiez l'identifiant du projet.");
        }

        $clientEntity = new Client();

        $clientEntity->addProjectId($projectEntity)
            ->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setNameSurname($data['nameSurname'])
            ->setIdDocumentPictureLink("link there")
            ->setIdPictureLink("link here")
            ->setIdDocNumber($data['idNumber'])
            ->setNationality($data['nationality'])
            ->setIsTeamLead(false)
            ->setGender($gender)
            ->setProfession($data['profession'])
            ->setMonthlyIncome($data['monthlyIncome'])
            ->setBirthDate($data['birthDate']);

        $this->entityManager->persist($clientEntity);
        $this->entityManager->flush();

    }

    public function getClientsByProjectId(string $projectId = null)
    {
        /*
        $result = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Client::class, 'c')
            ->innerJoin('c.projectId', 'p', Join::WITH, 'p.projectId = :projectId')
            ->setParameter('projectId', $projectId)
            ->setMaxResults(10)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()->getArrayResult();
        */

        $projectEntity = $this->getProjectById($projectId);
        return $projectEntity->getClients();
    }

    public function getClientById(int $clientId)
    {
        return $this->clientRepository->find($clientId);
    }

    public function getClientByIdNumber(string $clientIdNumber): Client
    {
        $client = $this->clientRepository->findOneBy(['idDocNumber' => $clientIdNumber]);

        if (! $client instanceof Client){
            //@Todo client not fount exception

            throw new EntityNotFoundException('Client not found');
        }

        return $client;
    }

    public function setClientProjectId(string $clientIdNumber, string $projectId): void
    {
        $client = $this->getClientByIdNumber($clientIdNumber);
        $project = $this->getProjectById($projectId);

        if (!$client instanceof Client) {
            //@Todo client not fount exception

            throw new EntityNotFoundException('Client not found');
        }

        if (!$project instanceof Project) {
            //@Todo client not fount exception

            throw new EntityNotFoundException('Project not found');
        }

        foreach ($client->getProjectId() as $item) {
            if (!$item->getIsFinished()) {
                //TODO: Review the right way to throw this exception
                throw new Exception("Ce client a un autre projet en cours qui n'est pas encore finalizé!");
            }
        }

        $client->addProjectId($project);

        $this->entityManager->flush();
    }

    public function getProjectById(string $projectId = null)
    {
        return $this->projectRepository->findOneBy(['projectId' => $projectId]);
    }

    public function getProjectsTeamLeads(array $projects): array
    {
        $teamLeads = [];

        /** @var Project $project */
        foreach ($projects as $project) {
            foreach ($project->getClients() as $client) {
                if ($client->getIsTeamLead()) {
                    $teamLeads[] = $client;
                }
            }
        }

        return $teamLeads;
    }

    public function addClient(array $data)
    {
        $data = ClientResolver::resolve($data);

        $clientCheck = $this->getClientByIdNumber($data['idNumber']);

        if ($clientCheck instanceof Client){
            throw new \Exception('Il existe déja un client avect le meme numéro de piece d\'identité, Essayé avec une autre piece d\'identité..');
        }

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        $clientEntity = new Client();

        $clientEntity
            ->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setNameSurname($data['nameSurname'])
            ->setIdDocumentPictureLink("link there")
            ->setIdPictureLink("link here")
            ->setIdDocNumber($data['idNumber'])
            ->setNationality($data['nationality'])
            ->setIsTeamLead(false)
            ->setGender($gender)
            ->setProfession($data['profession'])
            ->setMonthlyIncome($data['monthlyIncome'])
            ->setBirthDate($data['birthDate'])
            ->setBalance(0);

        $this->entityManager->persist($clientEntity);
        $this->entityManager->flush();
    }

    public function isEligible(array $clientAmountArray){
        $currentClient = $this->getClientByIdNumber($clientAmountArray['IdNumber']);
        if (!$currentClient instanceof Client) {
            //@Todo client not fount exception

            throw new EntityNotFoundException('Client not found');
        }

        $amount = (float)$clientAmountArray['amount'];

        foreach ($currentClient->getProjectId() as $project){
            if (!$project->getIsFinished()){
                return false;
            }
        }

        if ($amount/10 > $currentClient->getBalance()){
            return false;
        }

        return true;
    }
}