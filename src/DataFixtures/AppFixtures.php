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

        // Categories
        $categories = [];
        for ($i=0; $i <= 100 ; $i++) { 
        $category = new Categories();
        $category->setName($this->faker->word());

        $categories[] = $category;
        $manager->persist($category);
    }
        // Articles
        for ($j=0; $j <= 25; $j++) { 
            $article = new Articles();
            $article->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300));

            $manager->persist($article);
        }

        //User
        for ($u=0; $u < 10; $u++) { 
            $user = new User();
            $user->setEmail($this->faker->email())
                ->setUsername($this->faker->name())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');
                


                $manager->persist($user);
        }

        $manager->flush();

    }
}
