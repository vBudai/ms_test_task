<?php

namespace App\Factory;

use App\DTO\Request\User\RegisterUserRequest;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function fromRegisterRequest(RegisterUserRequest $request): User
    {
        $user = new User();
        $user
            ->setName($request->name)
            ->setEmail($request->email)
            ->setPhone($request->phone)
            ->setPassword($this->passwordHasher->hashPassword($user, $request->password));

        return $user;
    }
}
