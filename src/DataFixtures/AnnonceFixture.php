<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Annonce;
use Faker\Factory as Faker;

class AnnonceFixture extends Fixture
{
    // On demande à Symfony l'ObjectManager, qui permet d'insérer ou de mettre à jour la base de données
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        for ($i=0; $i < 100; $i++) {
            $annonce = new Annonce();
            $annonce
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(1, true))
                ->setPrice($faker->numberBetween(10, 1000))
                ->setStatus($faker->numberBetween(0, 4))
                ->setSold(false)
            ;
            $manager->persist($annonce);
        }


        $manager->flush();
    }
}
