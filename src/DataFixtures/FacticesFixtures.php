<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FacticesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i<4; $i++) {
            // $product = new Product();
            $user = new User;
            $user->setEmail('stef@gmeila.com' . $i);
            $user->setFirstname('firstname-' . $i);
            $user->setLastname('lastname-' . $i);
            $user->setUsername('username-'. $i);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword('password-'. $i);
            $user->setIsVerified('is_verified-'. $i);
            // $manager->persist($product);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
 
        
         
