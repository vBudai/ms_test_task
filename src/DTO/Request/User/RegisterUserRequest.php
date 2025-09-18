<?php

namespace App\DTO\Request\User;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserRequest
{
    #[Assert\Length(min: 1, max: 64)]
    public string $name;

    #[AppAssert\Phone]
    public string $phone;

    #[Assert\Email]
    #[Assert\Length(max: 64)]
    public string $email;

    #[Assert\Length(min: 4)]
    public string $password;
}
