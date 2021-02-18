<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Book;
use App\Entity\Stock;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $livre = new Book();
            $livre->setName($faker->sentence($nbWords = 5, $variableNbWords = true));
            $livre->setAuthor($faker->name($gender=null));
            $livre->setPrice($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 50));
            $livre->setDatePublication($faker->dateTime($max = 'now', $timezone = null));
 
            $manager->persist($livre);

            $stock = new Stock();
            $stock->setBook($livre);
            $stock->setCount($faker->randomDigit());
            $stock->setAdress($faker->streetAddress());
            $stock->setZipCode($faker->numberBetween($min = 10000, $max = 90000));
            $stock->setCity($faker->city());
            $stock->setLibrary('Librairie '.$faker->company());

            $manager->persist($stock);
        }

        $manager->flush();
    }
}
