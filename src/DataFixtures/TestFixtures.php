<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\Project;
use App\Helper\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $employee1 = new Employee();
        $employee1->setNameSurname('Gildas Decadjevi')
            ->setEmail('dodo@gmail.com')
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setPassword($this->passwordEncoder->encodePassword($employee1,'12345'))
            ->setRoles(['ROLE_EXPERT']);

        $manager->persist($employee1);

        $employee2 = new Employee();
        $employee2->setNameSurname('Marwane Tchassama')
            ->setEmail('demo@gmail.com')
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setPassword($this->passwordEncoder->encodePassword($employee2,'123456'))
            ->setRoles(['ROLE_BOSS']);

        $manager->persist($employee2);

       /* foreach (range(0, 1) as $index) {
            $this->loading($manager);
        }*/

        $manager->flush();
    }

    public function loading($manager)
    {
        $faker = Factory::create();

        $project = new Project();
        $project
            ->setName($faker->domainName)
            ->setAmount($faker->numberBetween(150000, 5000000))
            ->setExtra($faker->text)
            ->setProjectId(str_replace('.', '', uniqid('po', true)))
            ->setModalityAmount($faker->numberBetween(5000, 10000))
            ->setModalityPaymentFrequency($faker->numberBetween(0, 10))
            ->setRepaymentDuration($faker->numberBetween(0, 10))
            ->setStatus(Status::WAITING_FOR_CONTROL);
        $manager->persist($project);

        foreach (range(0, 3) as $index) {
            $client = new Client();
            $teamLead = $index === 1;
            $client
                ->setNameSurname($faker->firstNameMale)
                ->setEmail($faker->email)
                ->setBirthDate($faker->dateTimeBetween("-30 years"))
                ->setAddress($faker->address)
                ->setMonthlyIncome($faker->numberBetween(10000, 100000))
                ->setExtra($faker->text(200))
                ->setIsTeamLead($teamLead)
                ->setPhoneNumber($faker->phoneNumber)
                ->setNationality($faker->countryCode)
                ->setIdPictureLink($faker->imageUrl(640, 480))
                ->setIdDocumentPictureLink($faker->imageUrl(640, 480));

            $client->setProjectId($project);
            $manager->persist($client);
        }
    }
}
