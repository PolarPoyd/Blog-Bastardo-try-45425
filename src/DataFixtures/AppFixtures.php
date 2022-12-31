<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Articles;
use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager,): void
    {

        //Users
        $users = [];
        for ($u=0; $u < 10; $u++) { 
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setUsername($this->faker->name())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
                

                $users[] = $user;
                $manager->persist($user);
        }

        // Categories
        $categories = [];
        for ($i=0; $i <= 100 ; $i++) { 
        $category = new Categories();
        $category->setName($this->faker->word())
            ->setUser($users[mt_rand(0, count($users) - 1)]);


        $categories[] = $category;
        $manager->persist($category);
    }
        // Articles
        for ($j=0; $j <= 25; $j++) { 
            $article = new Articles();
            $article->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setUser($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($article);
        }

        $manager->flush();

    }
}
