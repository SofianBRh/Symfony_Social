<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {



        $faker = Faker\Factory::create('fr_FR');
        // on crée 4 auteurs avec noms et prénoms "aléatoires" en français
        $user = Array();
        for ($i = 0; $i < 4; $i++) {
            $user[$i] = new User();
        
            $user[$i]->setEmail($faker->Email);
            $user[$i]->setRoles($faker->roles);
            $user[$i]->setPassword($faker->password);
            $user[$i]->setFirstname($faker->firstname);
            $user[$i]->setLastname($faker->lastname);
            $user[$i]->setUsername($faker->username);
            $user[$i]->setIsVerified($faker->isVerified);
    

            $manager->persist($user[$i]);
        }

        $manager->flush();

    }
}
