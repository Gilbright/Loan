<?php


namespace App\Service;


use App\Entity\Client;
use App\Entity\Employee;
use App\Helper\RoleHelper;
use App\Repository\EmployeeRepository;
use App\Service\OptionsResolver\ClientResolver;
use App\Service\OptionsResolver\EmployeeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Config\Definition\Exception\Exception;

class EmployeeManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * @var EmployeeRepository $employeeRepository
     */
    private $employeeRepository;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository)
    {
        $this->entityManager = $entityManager;
        $this->employeeRepository = $employeeRepository;
    }

    public function execute(array $data): void
    {
        $data = EmployeeResolver::resolve($data);

        $employeeEntity = new Employee();

        $employeeEntity->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setNameSurname($data['nameSurname'])
            ->setIdDocumentPictureLink("link there")
            ->setIdPictureLink("link here")
            ->setNationality($data['nationality'])
            ->setGender("M") // TODO: THİS İS THE DEFAULT VERSİON TO BE FİXED LATER
            ->setRoles($this->roleParser($data['role']))
            ->setPassword('12345')
            ->setBirthDate($data['birthDate']);

        $this->entityManager->persist($employeeEntity);
        $this->entityManager->flush();

    }

    public function roleParser($role): array{
        switch (strtolower($role)){
            case 'secretaire':
                return [RoleHelper::SECRETARY];
            case 'directeur':
                return [RoleHelper::BOSS];
            case 'tresorier':
                return [RoleHelper::ACCOUNTANT];
            case 'expert':
                return [RoleHelper::EXPERT];
            default:
                throw new Exception('No Suitable Role Found');
        }
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

    public function getClientById(int $clientId)
    {
        return $this->clientRepository->find($clientId);
    }


    public function getProjectById(string $projectId = null)
    {
        return $this->projectRepository->findOneBy(['projectId' => $projectId]);
    }

    public function getProjectsTeamLeads(array $projects): array
    {
        $teamLeads = [];

        foreach ($projects as $project) {
            $teamLeads[] = $this->clientRepository->findOneBy([
                'projectId' => $project->getId(),
                'isTeamLead' => 1
            ]);
        }

        return $teamLeads;
    }
}