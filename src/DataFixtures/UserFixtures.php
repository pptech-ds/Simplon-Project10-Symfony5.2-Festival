<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        for($i=0;$i<5; $i++){
            $user = new User();
            // ...
            $user->setEmail('user'.$i.'@test.com');
            $plainPassword = '123456';
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $plainPassword
            ));
            $manager->persist($user);

            // ...
        }

        $manager->flush();
    }

    // public function load(ObjectManager $manager)
    // {
    //     for($i=0;$i<5; $i++){
    //         $user = new User();
    //         $user->setEmail('user'.$i.'@test.com');
    //         $plainPassword = '123456';
    //         // $encoded = $encoder->encodePassword($user, $plainPassword);
    //         $user->setPassword($plainPassword);
    //         $manager->persist($user);
    //     }

    //     $manager->flush();
    // }
}
