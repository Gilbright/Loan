<?php


namespace App\Service;


use App\Entity\Employee;
use App\Helper\RoleHelper;
use App\Repository\EmployeeRepository;
use App\Service\OptionsResolver\EmployeeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * @var EmployeeRepository $employeeRepository
     */
    private $employeeRepository;

    /**
     * @var UserPasswordEncoderInterface $passWordEncoder
     */
    private $passwordEncoder;

    /**
     * ProjectManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EntityManagerInterface $entityManager, EmployeeRepository $employeeRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
        $this->entityManager = $entityManager;
        $this->employeeRepository = $employeeRepository;
    }


    public function execute(array $data): void
    {
        $data = EmployeeResolver::resolve($data);

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        $employeeEntity = new Employee();

        $encodedPassword = $this->passwordEncoder->encodePassword($employeeEntity, 'phenix');

        $employeeEntity->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setNameSurname($data['nameSurname'])
            ->setIdDocumentPictureLink("link there")
            ->setIdPictureLink("link here")
            ->setNationality($data['nationality'])
            ->setGender($gender)
            ->setIdDocNumber($data['idNumber'])
            ->setRoles($this->roleParser($data['role']))
            ->setPassword($encodedPassword)
            ->setBirthDate($data['birthDate']);

        $this->entityManager->persist($employeeEntity);
        $this->entityManager->flush();
    }

    public function roleParser($role): array
    {
        switch (strtolower($role)) {
            case 'secretaire':
                return [RoleHelper::SECRETARY];
            case 'directeur':
                return [RoleHelper::BOSS];
            case 'tresorier':
                return [RoleHelper::ACCOUNTANT];
            case 'expert':
                return [RoleHelper::EXPERT];
            default:
                throw new Exception('Aucun Role Correspondant au choix de fonction effectué');
        }
    }

    /**
     * @return Employee[]
     */
    public function getEmployees(): array
    {
        return $this->employeeRepository->findAll();
    }

    public function getEmployeesByRole($role)
    {
        $qb = $this->entityManager->createQueryBuilder();
        return $qb->select('u')
            ->from(Employee::class, 'u')
            ->where('u.roles like :roles')
            ->setParameter('roles', '%"' . $role . '"%')
            ->getQuery()->getResult();
    }

    public function updateEmployeeInfos(array $data, Employee $employee): void
    {
        $employee
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
        ;

        if ($data['address']){
            $employee->setAddress($data['address']);
        }

        if ($data['password']){
            $password = $this->passwordEncoder->encodePassword($employee, $data['password']);
            $employee->setPassword($password);
        }

        $this->entityManager->flush();
    }
}