<?php


namespace App\Service;


use App\Entity\Users;
use App\Helper\RoleHelper;
use App\Repository\UsersRepository;
use App\Service\OptionsResolver\EmployeeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeManager
{
    private EntityManagerInterface $entityManager;

    private UsersRepository $usersRepository;

    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UsersRepository $usersRepository
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $entityManager, UsersRepository $usersRepository, UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param array $data
     */
    public function execute(array $data): void
    {
        $data = EmployeeResolver::resolve($data);

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        $userEntity = new Users();

        $encodedPassword = $this->passwordEncoder->encodePassword($userEntity, 'phenix');

        $userEntity->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setFullName($data['nameSurname'])
            ->setIdDocUrl("link there")
            ->setPhotoUrl("link here")
            ->setNationality($data['nationality'])
            ->setGender($gender)
            ->setIdDocNumber($data['idDocNumber'])
            ->setRoles($this->roleParser($data['role']))
            ->setPassword($encodedPassword)
            ->setBirthDate($data['birthDate']);

        $this->entityManager->persist($userEntity);
        $this->entityManager->flush();
    }

    /**
     * @param $role
     * @return array
     */
    public function roleParser($role): array
    {
        return match (strtolower($role)) {
            RoleHelper::SECRETARY_FR => [RoleHelper::SECRETARY],
            RoleHelper::BOSS_FR => [RoleHelper::BOSS],
            RoleHelper::ACCOUNTANT_FR => [RoleHelper::ACCOUNTANT],
            RoleHelper::EXPERT_FR => [RoleHelper::EXPERT],
            default => throw new Exception('Aucun Role Correspondant au choix de fonction effectué'),
        };
    }

    /**
     * @return Users[]
     */
    public function getUsers(): array
    {
        return $this->usersRepository->findAll();
    }

    public function getUsersByRole($role)
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb->select('u')
            ->from(Users::class, 'u')
            ->where('u.roles like :roles')
            ->setParameter('roles', '%"' . $role . '"%')
            ->getQuery()->getResult();
    }

    public function updateUserInfos(array $data, Users $user): void
    {
        $user
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
        ;

        if ($data['address']){
            $user->setAddress($data['address']);
        }

        if ($data['password']){
            $password = $this->passwordEncoder->encodePassword($user, $data['password']);
            $user->setPassword($password);
        }

        $this->entityManager->flush();
    }
}