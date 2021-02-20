<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Project;
use App\Helper\Status;
use App\Repository\ClientRepository;
use App\Service\OptionsResolver\ClientResolver;
use Doctrine\ORM\EntityManagerInterface;

class ClientManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    private $clientsArray;
    /**
     * @var ClientRepository $clientRepository
     */
    private $clientRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->clientsArray = [];
    }

    public function execute(array $data): void
    {
        $data = ClientResolver::resolve($data);

        $clientEntity = new Client();

       /* $clientEntity->setProjectId(new Project())
            ->setAddress("")
            ->setPhoneNumber("")
            ->setEmail("")
            ->setNameSurname("")
            ->setIdDocumentPictureLink("")
            ->setIdPictureLink("")
            ->setNationality("")
            ->setIsTeamLead(false)
            ->setMonthlyIncome("")
            ->setBirthDate("");*/

        $this->clientsArray[] = $this->clientsArray;

       /* $this->entityManager->persist($projectEntity);
        $this->entityManager->flush();*/

    }

    public function getClients(string $projectId = null): array
    {
        return $this->clientRepository->findBy(
            ['projectId' => $projectId]
        );
    }

    /**
     * @return array
     */
    public function getClientsArray(): array
    {
        return $this->clientsArray;
    }

    /**
     * @param array $clientsArray
     */
    public function setClientsArray(array $clientsArray): void
    {
        $this->clientsArray = $clientsArray;
    }


}