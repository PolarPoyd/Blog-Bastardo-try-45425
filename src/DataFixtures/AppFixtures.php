<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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

    public function load(ObjectManager $manager): void
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

        $manager->flush();

    }
}
