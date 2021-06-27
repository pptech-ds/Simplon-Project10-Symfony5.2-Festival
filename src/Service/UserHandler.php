<?php

namespace App\Service;

use Symfony\Component\Security\Core\Security;

class UserHandler
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    public function getUserInfos()
    {
        $user = $this->security->getUser(); 

        return $user;
    }
}