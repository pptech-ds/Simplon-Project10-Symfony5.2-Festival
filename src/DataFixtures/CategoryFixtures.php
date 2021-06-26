<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ['Mélodique', 'Industrielle', 'Groovy', 'Deep', 'Détroit'];

        for($i=0; $i<count($categories); $i++) {
            $category = new Category;
            $category->setName($categories[$i]);
            $manager->persist($category);

            // Creating references to get them in ArtitFixtures
            $this->addReference('category_' . $i, $category);
        }
        $manager->flush();
    }
}