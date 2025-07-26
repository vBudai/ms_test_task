<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class CartItemExists extends Constraint
{
    public string $message = 'Этого товара нет в корзине';
}
