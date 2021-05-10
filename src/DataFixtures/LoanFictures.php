<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LoanFictures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for($x = 0; $x <= 20; $x++){

        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
