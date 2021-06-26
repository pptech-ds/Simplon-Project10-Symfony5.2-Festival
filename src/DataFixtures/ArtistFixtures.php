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
            $category = $this->getReference('category_' . $faker->numberBetween(1, 5));
            $artist = new Artist;
            if(rand(1,50) < 40) {
                $artist->setCategory($category);
            }
            if($concert < 10 && rand(1,50) < 5) {
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
        // retourne la liste des dépendances du notre objet, qui doivent s'exécuter avant
        return [
            CategoryFixtures::class            
        ];
    }
}