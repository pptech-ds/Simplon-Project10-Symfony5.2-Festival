<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CatergoryFixtures extends Fixture
{

    // public const CATEGORY_REFERENCE = 'category_test';


    public function load(ObjectManager $manager)
    {
        for($i=0;$i<5; $i++){
            $catName = 'Cat'.$i;
            $category = new Category();
            $category->setName($catName);
            $category->setColor('color'.$i);

            $this->addReference( $catName, $category);
            
            $manager->persist($category);

            
        }

        // $this->addReference(self::CATEGORY_REFERENCE, $category);

        $manager->flush();

        
    }
}
