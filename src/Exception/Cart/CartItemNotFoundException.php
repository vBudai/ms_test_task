<?php

namespace App\Exception\Cart;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CartItemNotFoundException extends \Exception
{
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("Товар в корзине не найден", Response::HTTP_BAD_REQUEST, $previous);
    }
}
