<?php


namespace App\Service;


use App\Entity\Users;
use App\Helper\RoleHelper;
use App\Helper\UploaderHelper;
use App\Repository\UsersRepository;
use App\Service\OptionsResolver\EmployeeResolver;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeeManager
{
    private EntityManagerInterface $entityManager;

    private UsersRepository $usersRepository;

    private UserPasswordHasherInterface $passwordEncoder;

    private UploaderHelper $uploaderHelper;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UsersRepository $usersRepository
     * @param UserPasswordHasherInterface $encoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UsersRepository $usersRepository,
        UserPasswordHasherInterface $encoder,
        UploaderHelper $uploaderHelper
    )
    {
        $this->passwordEncoder = $encoder;
        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->uploaderHelper = $uploaderHelper;
    }

    /**
     * @param array $data
     */
    public function execute(array $data): void
    {
        $data = EmployeeResolver::resolve($data);

        $gender = $data['gender'] === 'Homme' ? 'H' : 'F';

        $userEntity = new Users();

        $encodedPassword = $this->passwordEncoder->hashPassword($userEntity, '123456');

        $idDocNumber = $data['idNumber'];

        $idDocPathName = $this->uploaderHelper->uploadPhenixFile($data['pieceIdentity'], $idDocNumber.UploaderHelper::USER_ID_DOC_PATH_NAME);
        $idPathName = $this->uploaderHelper->uploadPhenixFile($data['photoIdentity'], $idDocNumber.UploaderHelper::USER_ID_PATH_NAME);

        $userEntity->setAddress($data['address'])
            ->setPhoneNumber($data['phoneNumber'])
            ->setEmail($data['email'])
            ->setUsername($data['email'])
            ->setFullName($data['nameSurname'])
            ->setIdDocUrl($idDocPathName)
            ->setPhotoUrl($idPathName)
            ->setNationality($data['nationality'])
            ->setGender($gender)
            ->setIdDocNumber($data['idNumber'])
            ->setRoles($this->roleParser($data['role']))
            ->setPassword($encodedPassword)
            ->setIsActive(true)
            ->setBirthDate(new \DateTimeImmutable($data['birthDate']))
        ;

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

    public function deleteUser($userIdNumber)
    {
        $user = $this->getUserByIdNumber($userIdNumber);

        $prefix = 'deleted_' . (new \DateTime())->format('d-m-Y') . '_';

        $user->setIsActive(1)
            ->setEmail($prefix . $user->getEmail())
            ->setUsername($user->getEmail());

        $this->entityManager->flush();

        return true;
    }

    public function getUserByIdNumber($idNumber)
    {
        $user = $this->usersRepository->findOneBy(['idDocNumber' => $idNumber]);

        if (!$user instanceof Users) {
            throw new EntityNotFoundException('Cet employé n a pas été retrouvé');
        }

        return $user;
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
            $password = $this->passwordEncoder->hashPassword($user, $data['password']);
            $user->setPassword($password);
        }

        $this->entityManager->flush();
    }
}