<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i<50; $i++) {
            $personne = new Personne();
            $personne->setName($faker->name());
            $personne->setAge($faker->numberBetween(1,99));
            $manager->persist($personne);
        }
        $manager->flush();
    }
}
