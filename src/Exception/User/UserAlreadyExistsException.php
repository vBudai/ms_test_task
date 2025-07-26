<?php

namespace App\Exception\User;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserAlreadyExistsException extends \Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("Пользователь с таким телефоном или почтой уже существует", Response::HTTP_CONFLICT, $previous);
    }
}
