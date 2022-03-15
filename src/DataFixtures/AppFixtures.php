<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Post;
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
        // create users
        foreach($this->generateUser() as $user) {
            $manager->persist($user);
            // create post for users
            if(!$user->isVerified()) {
                continue;
            }
            foreach($this->generatePost($user) as $post) {
                $manager->persist($post);
            }
        }
        $manager->flush();
    }

    private function generatePost(User $user): \Generator
    {
        for ($i = 1; $i <= $this->faker->randomDigitNotNull(); $i++) {
            $post = new Post();
            $post->setTitle(implode(' ', $this->faker->words(4)));
            $post->setContent(implode(' ', $this->faker->words(50)));
            $post->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-6 months')));
            $post->setStatus($this->faker->randomElement(['published', 'unpublished']));
            $post->setUser($user);
            yield $post;
        }
    }

    private function generateUser(): \Generator
    {
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
