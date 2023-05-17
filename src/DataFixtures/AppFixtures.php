<?php

namespace App\DataFixtures;

use App\Entity\Modules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $modules = new Modules(); // Remplacez "YourEntity" par le nom de votre entité

            $modules->setName($faker->name);
            $modules->setCreatedAt(new \DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i')));
            $modules->setState($faker->randomElement(['actif', 'inactif']));
            $modules->setType($faker->randomElement(['Rapide', 'Lent']));
            $modules->setLastExecution(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i')));

            $manager->persist($modules);
        }

        $manager->flush();
    }
    
}