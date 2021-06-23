<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<5; $i++){
            $user = new User();
            $user->setEmail('user'.$i.'@test.com');
            $plainPassword = '123456';
            // $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($plainPassword);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
