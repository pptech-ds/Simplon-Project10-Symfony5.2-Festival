<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Artist;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $concert = 1;

        for($i = 1; $i <= 200; $i++ ) {
            // getting references created in CategoryFixtures
            $category = $this->getReference('category_' . $faker->numberBetween(0, 4));
            $artist = new Artist;

            // rand used to generated some artists not in any specific category
            if(rand(1,50) < 40) {
                $artist->setCategory($category);
            }

            // rand used to set artist in concert randomly 
            if($concert <= 9 && (rand(75,150) < 80)) {
                $artist->setConcert($concert);
                $concert++;
            }
            $artist->setName('DJ '.$faker->lastName);
            $artist->setDescription($faker->paragraph(10,true));
            $manager->persist($artist);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // dependencies
        return [
            CategoryFixtures::class            
        ];
    }
}