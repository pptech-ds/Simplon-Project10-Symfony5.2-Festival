<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CatergoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<5; $i++){
            $category = new Category();
            $category->setName('Cat'.$i);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
