<?php

namespace App\DataFixtures;

use App\Entity\Pin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PinFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++)
        {
            $pin = new Pin();
            $pin->setTitle("Pin " .$i)
                ->setDescription("Description of pin " .$i);

            $manager->persist($pin);
        }

        $manager->flush();
    }
}
