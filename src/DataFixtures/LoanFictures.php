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

class LoanFictures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $employee1 = new Employee();
        $employee1->setNameSurname('Gildas Decadjevi')
            ->setEmail('dodo@gmail.com')
            ->setBirthDate($faker->dateTimeBetween("-30 years")->format('d/m/Y'))
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setGender('homme')
            ->setNationality($faker->country)
            ->setIdDocNumber($faker->numberBetween(12,1000))
            ->setPassword($this->passwordEncoder->encodePassword($employee1,'12345'))
            ->setRoles(['ROLE_EXPERT']);

        $manager->persist($employee1);

        $employee2 = new Employee();
        $employee2->setNameSurname('Marwane Tchassama')
            ->setEmail('demo@gmail.com')
            ->setBirthDate($faker->dateTimeBetween("-30 years")->format('d/m/Y'))
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setGender('homme')
            ->setNationality($faker->country)
            ->setIdDocNumber($faker->numberBetween(12,1000))
            ->setPassword($this->passwordEncoder->encodePassword($employee2,'12345'))
            ->setRoles(['ROLE_BOSS']);

        $employee3 = new Employee();
        $employee3->setNameSurname('Merlin Tchassamooo')
            ->setEmail('dada@gmail.com')
            ->setBirthDate($faker->dateTimeBetween("-30 years")->format('d/m/Y'))
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setGender('homme')
            ->setIdDocNumber($faker->numberBetween(12,1000))
            ->setNationality($faker->country)
            ->setPassword($this->passwordEncoder->encodePassword($employee2,'12345'))
            ->setRoles(['ROLE_SECRETARY']);

        $manager->persist($employee2);
        $manager->persist($employee3);

        $employee4 = new Employee();
        $employee4->setNameSurname('Turan Tiam')
            ->setEmail('dede@gmail.com')
            ->setBirthDate($faker->dateTimeBetween("-30 years")->format('d/m/Y'))
            ->setPhoneNumber('05385817620')
            ->setAddress('Ataşehir')
            ->setGender('homme')
            ->setIdDocNumber($faker->numberBetween(12,1000))
            ->setNationality($faker->country)
            ->setPassword($this->passwordEncoder->encodePassword($employee2,'12345'))
            ->setRoles(['ROLE_ACCOUNTANT']);

        $manager->persist($employee4);

         foreach (range(0, 50) as $index) {
             $this->loading($manager);
         }

        $manager->flush();
    }

    public function loading($manager)
    {
        $faker = Factory::create();

        $project = new Project();
        $project
            ->setName($faker->domainName)
            ->setAmount($faker->numberBetween(1500000, 5000000))
            ->setExtra($faker->text)
            ->setProjectId(str_replace('.', '', uniqid('ph', false)))
            ->setModalityAmount($faker->numberBetween(50000, 150000))
            ->setModalityPaymentFrequency($faker->numberBetween(0, 10))
            ->setRepaymentDuration($faker->numberBetween(5, 24))
            ->setIsFinished(false)
            ->setDetails($faker->text(300))
            ->setStatus(Status::SEC_WAITING_FOR_CONTROL);
        $manager->persist($project);

        foreach (range(0, 3) as $index) {
            $client = new Client();
            $teamLead = $index === 1;
            $client
                ->setNameSurname($faker->firstNameMale)
                ->setEmail($faker->email)
                ->setProfession($faker->jobTitle)
                ->setBirthDate($faker->dateTimeBetween("-30 years")->format('d/m/Y'))
                ->setAddress($faker->address)
                ->setMonthlyIncome($faker->numberBetween(10000, 100000))
                ->setExtra($faker->text(200))
                ->setIsTeamLead($teamLead)
                ->setPhoneNumber($faker->phoneNumber)
                ->setBalance(0)
                ->setGender('Homme')
                ->setIdDocNumber(str_replace('.', '', uniqid('id', false)))
                ->setNationality($faker->countryCode)
                ->setIdPictureLink($faker->imageUrl(640, 480))
                ->setIdDocumentPictureLink($faker->imageUrl(640, 480));

            $client->addProjectId($project);
            $manager->persist($client);
        }
    }
}
