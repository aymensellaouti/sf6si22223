<?php

namespace App\DataFixtures;

use App\Entity\Club;
use App\Entity\Cours;
use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr');
        for ($i=0; $i < 20 ; $i++) {
            $club =  new Club();
            $club->setDesignation($faker->company());
            $manager->persist($club);
        }
        for ($i=0; $i < 20 ; $i++) {
            $profil =  new Profil();
            $profil->setEmail($faker->email());
            $manager->persist($profil);
        }
        for ($i=0; $i < 20 ; $i++) {
            $cours =  new Cours();
            $cours->setDesignation("Cours$i");
            $manager->persist($cours);
        }

        $manager->flush();
    }
}
