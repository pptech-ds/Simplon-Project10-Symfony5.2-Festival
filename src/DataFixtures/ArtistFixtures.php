<?php

namespace App\DataFixtures;

use App\Entity\Artist;
// use App\Entity\Category;
use App\DataFixtures\CatergoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // for($i=0;$i<5; $i++){
        //     $catName = 'Cat'.$i;
        //     $category = $this->getReference($catName);
        //     // $category->setName('Cat'.$i);
        //     // $manager->persist($category);

        //     for($j=0;$j<20; $j++){
        //         $artist = new Artist();
        //         $artist->setName('Artist'.$j);
        //         $artist->setIsLive(0);
        //         $artist->setCategory($category);
        //         $manager->persist($artist);
        //     } 
        // }

        // $manager->flush();
    }
}
