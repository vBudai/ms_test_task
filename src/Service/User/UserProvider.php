<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\User\UserNotAuthenticatedException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

readonly class UserProvider
{
    public function __construct(
        private Security $security
    ){}

    /**
     * @throws UserNotAuthenticatedException
     * @throws \Exception
     */
    public function getUser(): User
    {
        $user = $this->security->getUser();
        if($user === null){
            throw new UserNotAuthenticatedException();
        }
        if(!($user instanceof User)){
            throw new \Exception("Неправильный Entity пользователя");
        }

        return $user;
    }
}
