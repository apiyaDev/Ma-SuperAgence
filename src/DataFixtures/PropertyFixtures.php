<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();
        for ($i=0; $i < 20; $i++) { 
            
            $property = new Property();
            $property->setTitle($faker->text($maxNbChars = 10))
                     ->setDescription($faker->text($maxNbChars = 100))
                     ->setSurface($faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'))
                     ->setRooms($faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'))
                     ->setBedrooms($faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'))
                     ->setFloor($faker->biasedNumberBetween($min = 10, $max = 20, $function = 'sqrt'))
                     ->setHeat($faker->biasedNumberBetween($min = 1, $max = 2, $function = 'sqrt'))
                     ->setCity($faker->city())
                     ->setAdresse($faker->streetAddress())
                     ->setPostalCode($faker->postcode())
                     ->setPrice($faker->randomNumber(2))
            ;         
            
            $manager->persist($property);

        }

        $manager->flush();
    }
}
