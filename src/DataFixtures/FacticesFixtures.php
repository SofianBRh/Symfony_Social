<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Controller\RegistrationController;
use Faker;

class FacticesFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        
        for ($i = 0; $i<5; $i++) {
            // $product = new Product();
            $user = new User;
            $user->setEmail($faker->email);
            $user->setFirstname($faker->firstname);
            $user->setLastname($faker->lastname);
            $user->setUsername($faker->username);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    'test'
                )
            );
            $user->setIsVerified($faker->boolean);
            // $manager->persist($product);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
