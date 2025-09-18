<?php

namespace App\Exception\User;

use Symfony\Component\HttpFoundation\Response;

class UserNotAuthenticatedException extends \Exception
{
    public function __construct(?\Throwable $previous = null)
    {
        parent::__construct('Пользователь не аутентифицирован', Response::HTTP_UNAUTHORIZED, $previous);
    }
}
