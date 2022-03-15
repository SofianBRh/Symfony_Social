<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    private $faker;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->faker = Faker\Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        foreach($this->generateUser() as $user) {
            $manager->persist($user);
            dump($user->getUsername());
        }
        $manager->flush();
    }

    private function generateUser() {
        for ($i = 1; $i <= 20; $i++) {
            $user = new User;
            $user->setEmail($this->faker->email);
            $user->setFirstname($this->faker->firstname);
            $user->setLastname($this->faker->lastname);
            $user->setUsername($this->faker->username);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    'test'
                )
            );
            $user->setIsVerified($this->faker->boolean(90));
            yield $user;
        }
    }
}
