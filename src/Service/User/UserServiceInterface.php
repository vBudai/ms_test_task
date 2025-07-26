<?php

namespace App\Service\User;

use App\DTO\Request\User\RegisterUserRequest;
use App\Entity\User;

interface UserServiceInterface
{
    public function register(RegisterUserRequest $request): User;
}
