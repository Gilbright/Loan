<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Project;
use App\Entity\ProjectMaster;
use App\Helper\UploaderHelper;
use App\Repository\ClientRepository;
use App\Repository\ProjectMasterRepository;
use App\Service\OptionsResolver\ClientResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Definition\Exception\Exception;

class ClientManager
{
    private EntityManagerInterface $entityManager;

    private ClientRepository $clientRepository;

    private ProjectMasterRepository $projectMasterRepository;

    private UploaderHelper $uploaderHelper;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     * @param ProjectMasterRepository $projectMasterRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository,
        ProjectMasterRepository $projectMasterRepository,
        UploaderHelper $uploaderHelper
    )
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->projectMasterRepository = $projectMasterRepository;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getClientsByRequestId(string $requestId = null)
    {
        $projectMaster = $this->getProjectMasterByRequestId($requestId);

        return $projectMaster->getClients();
    }

    public function getClientById(int $clientId): ?Client
    {
        $client = $this->clientRepository->find($clientId);

        if (!$client instanceof Client){
            //@Todo client not fount exception
            throw new EntityNotFoundException('Client not found');
        }

        return $client;
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

    public function setClientProjectMaster(string $clientIdNumber, string $requestId): void
    {
        $client = $this->getClientByIdNumber($clientIdNumber);
        $projectMaster = $this->getProjectMasterByRequestId($requestId);

        foreach ($client->getProjectMasters() as $_projectMaster) {
            if (!$_projectMaster->getIsFinished()) {
                //TODO: Review the right way to throw this exception
                throw new Exception("Ce client a un autre projet en cours qui n'est pas encore finalizé!");
            }
        }

        $client->addProjectMaster($projectMaster);

        $this->entityManager->flush();
    }

    public function getProjectMasterByRequestId(string $requestId = null)
    {
        $projectMaster = $this->projectMasterRepository->findOneBy(['requestId' => $requestId]);

        if (!$projectMaster instanceof ProjectMaster) {
            throw new EntityNotFoundException("Ce Projet n'existe pas, reverifiez l'identifiant du projet.");
        }

        return $projectMaster;
    }

    public function getProjectsTeamLeads(array $projects): array
    {
        $teamLeads = [];

        /** @var Project $project */
        foreach ($projects as $project) {
            foreach ($project->getProjectMaster()->getClients() as $client) {
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

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        $clientEntity = new Client();

        $idDocNumber = $data['idNumber'];

        $idDocPathName = $this->uploaderHelper->uploadPhenixFile($data['pieceIdentity'], $idDocNumber.UploaderHelper::ID_DOC_PATH_NAME);
        $idPathName = $this->uploaderHelper->uploadPhenixFile($data['photoIdentity'], $idDocNumber.UploaderHelper::ID_PATH_NAME);

        $clientEntity
            ->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setFullName($data['nameSurname'])
            ->setIdDocPictureUrl($idDocPathName)
            ->setIdPictureUrl($idPathName)
            ->setIdDocNumber($idDocNumber)
            ->setNationality($data['nationality'])
            ->setIsTeamLead(false)
            ->setGender($gender)
            ->setProfession($data['profession'])
            ->setMonthlyIncome($data['monthlyIncome'])
            ->setBirthDate(new \DateTimeImmutable($data['birthDate']))
            ->setBalance(0)
        ;

        $this->entityManager->persist($clientEntity);
        $this->entityManager->flush();
    }

    public function isEligible(array $clientAmountArray): array
    {
        $client = $this->getClientByIdNumber($clientAmountArray['IdNumber']);

        $amount = (int)$clientAmountArray['amount'];

        $result = [
            'idNumber' => $client->getIdDocNumber()
        ];

        foreach ($client->getProjectMasters() as $projectMaster){
            if (!$projectMaster->getIsFinished()){
                $result['isEligible'] = false;
                return $result;
            }
        }

        if (round($amount/10, 2) > round($client->getBalance(), 2)){
            $result['isEligible'] = false;
            return $result;
        }

        $result['isEligible'] = true;
        return $result;
    }

    /**
     * @param $projectMasters
     * @return array
     * You can mark functions that do not produce any side effects as pure.
     * Such functions can be safely removed if the result from executing them is not used in the code after. [Pure]
     */
    #[Pure] public function getClientProjects($projectMasters): array
    {
        $projectCollection = [];

        /** @var ProjectMaster $projectMaster */
        foreach ($projectMasters as $projectMaster) {
            if ($project = $projectMaster->getProject()) {
                $projectCollection[] = $project;
            }
        }

        return $projectCollection;
    }

    public function doFlush()
    {
        $this->entityManager->flush();
    }
}