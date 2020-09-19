<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("marwane@example.com")
            ->setFirstName("Master")
            ->setLastName("Big");
        $encodePassword = $this->passwordEncoder->encodePassword($user,"Mahaboub97");

        $user->setPassword($encodePassword);

        $manager->persist($user);

        $manager->flush();

        $user = new User();

        $user->setEmail("mahaboub@example.com")
            ->setFirstName("Mahaboub")
            ->setLastName("Small");

        $encodePassword = $this->passwordEncoder->encodePassword($user,"Mardiatou15");

        $user->setPassword($encodePassword);

        $manager->persist($user);

        $manager->flush();
    }
}
