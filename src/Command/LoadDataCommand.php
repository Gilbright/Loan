<?php

namespace App\Command;

use App\Entity\Users;
use App\Helper\UploaderHelper;
use App\Repository\ClientRepository;
use App\Repository\ProjectMasterRepository;
use App\Service\ClientManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'load:data:command',
    description: 'Add a short description for your command',
)]
class LoadDataCommand extends Command
{
    /** @var UserPasswordHasherInterface  */
    private $passwordEncoder;

    /** @var EntityManagerInterface */
    private  $em;

    private  UploaderHelper $uploaderHelper;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordEncoder,
        string $name = null)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->info('[PROCESS STARTED]');

        $users = [
            [
                'full_name' => 'Marwane Tchassama',
                'email' => 'marwane.tchassama@bil.omu.edu.tr',
                'role'  => 'ROLE_BOSS',
            ],
            [
                'full_name' => 'Mardia Tchassama',
                'email' => 'mahabnadjib@gmail.com',
                'role' => 'ROLE_EXPERT',
            ],
            [
                'full_name' => 'Mahaboub Tchassama',
                'email' => 'nadjibmahab@gmail.com',
                'role' => 'ROLE_ACCOUNTANT',
            ],
            [
                'full_name' => 'Nadjib Tchassama',
                'email' => 'tchassanadjib.mar@gmail.com',
                'role' => 'ROLE_SECRETARY',
            ]
        ];

        $io->info('[USERS ARE CREATING]');

        foreach ($users as $index => $user) {
            $_user = (new Users())
                ->setFullName($user['full_name'])
                ->setIdDocNumber(md5(uniqid()))
                ->setGender('Male')
                ->setAddress('Istanbul')
                ->setNationality('TR')
                ->setPhoneNumber('1234567898')
                ->setEmail($user['email'])
                ->setBirthdate(new \DateTime('-24 years'))
                ->setIdDocUrl('default')
                ->setIsActive(true)
                ->setLastLogin(new \DateTime())
                ->setPhotoUrl('default')
                ->setUsername($user['email'])
                ->setRoles([$user['role']])
            ;

            $_user->setPassword($this->passwordEncoder->hashPassword($_user, '123456'));

            $this->em->persist($_user);
            $this->em->flush();

            $io->info(sprintf('[USER - %d IS CREATED]', $index+1));
        }

        $io->info('[PROCESS FINISHED]');

        return Command::SUCCESS;
    }
}
