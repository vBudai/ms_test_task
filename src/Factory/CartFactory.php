<?php

namespace App\Factory;

use App\Entity\Cart;
use App\Entity\User;

final readonly class CartFactory
{
    public function createForUser(User $user): Cart
    {
        $cart = new Cart();
        $cart->setRelatedUser($user);

        return $cart;
    }
}
