<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Note;
use App\Entity\PaymentDetails;
use App\Entity\Project;
use App\Entity\ProjectMaster;
use App\Entity\SavingDetails;
use App\Entity\Users;
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
        $faker = Factory::create('tr_TR');

        $user = new Users();
        $email = $faker->companyEmail;
        $user
            ->setFullName($faker->lastName . $faker->firstNameMale)
            ->setIdDocNumber($faker->uuid)
            ->setGender('Male')
            ->setAddress($faker->address)
            ->setPhoneNumber($faker->phoneNumber)
            ->setEmail($email)
            ->setBirthdate($faker->dateTimeBetween('-30 years', '-20 years', null))
            ->setIdDocUrl('default')
            ->setIsActive(false)
            ->setLastLogin(new \DateTime())
            ->setPhotoUrl('default')
            ->setUsername($email)
            ->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN'])
        ;

        $user->setPassword($this->passwordEncoder->encodePassword($user, '123456'));

        for ($a = 0; $a <= random_int(3, 7); ++$a) {
            $projectMaster = new ProjectMaster();
            $projectMaster
                ->setEndDate(null)
                ->setEvaluation(null)
                ->setIsAbandoned(false)
                ->setIsFinished(false)
                ->setRequestId('ph_'.$faker->ean8);

            $project = new Project();
            $amount = $faker->randomFloat(10, 200000, 500000);
            $project
                ->setStatus(Status::SEC_WAITING_FOR_CONTROL)
                ->setName($faker->realText(20))
                ->setAmount($amount)
                ->setDetails($faker->realText(350))
                ->setBusinessPlanDocUrl('default')
                ->setDetailsExtraDocUrl('default')
                ->setExtra([])
                ->setFinalAmount(0)
                ->setModalityAmount(50000)
                ->setModalityPaymentFrequency(2)
                ->setProjectMaster($projectMaster)
                ->setRepaymentDuration(ceil($amount / 2 / 50000))
            ;

            for ($i = 0; $i <= random_int(1, 5); ++$i) {
                $client = new Client();

                if (0 === $i % 2) {
                    $name = $faker->firstNameFemale;
                    $gender = 'Female';
                } else {
                    $name = $faker->firstNameMale;
                    $gender = 'Male';
                }

                $client
                    ->setExtra([])
                    ->setBirthdate($faker->dateTimeBetween('-30 years', '-20 years', null))
                    ->setEmail($faker->freeEmail)
                    ->setPhoneNumber($faker->phoneNumber)
                    ->setAddress($faker->address)
                    ->setBalance(20000)
                    ->setFullName($name . $faker->lastName)
                    ->setGender($gender)
                    ->setIdDocNumber($faker->swiftBicNumber)
                    ->setIdDocPictureUrl('default')
                    ->setIdPictureUrl('default')
                    ->setMonthlyIncome(350000)
                    ->setNationality($faker->country)
                    ->setProfession($faker->jobTitle)
                    ->addProjectMaster($projectMaster)
                ;

                if (0 === $i) {
                    $projectMaster->setTeamLeadDocId($client->getIdDocNumber());
                }

                $savingDetails = new SavingDetails();
                $savingDetails
                    ->setType(false)
                    ->setAmount(20000)
                    ->setExtra([])
                    ->setClient($client)
                    ->setDetailDocUrl('default')
                    ->setPaidMonth(1)
                    ->setUser($user)
                ;

                $manager->persist($client);
                $manager->persist($savingDetails);
            }

            $paymentDetails = new PaymentDetails();

            $paymentDetails
                ->setExtra([])
                ->setProjectMaster($projectMaster)
                ->setAmount(0)
                ->setUser($user)
                ->setAmountToReceive(0)
                ->setAmountToSend($project->getAmount())
                ->setType(false)
            ;

            $note = new Note();
            $note
                ->setUser($user)
                ->setProject($project)
                ->setContent($faker->realText())
            ;

            $manager->persist($projectMaster);
            $manager->persist($project);
            $manager->persist($paymentDetails);
            $manager->persist($note);
        }

        $manager->persist($user);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
