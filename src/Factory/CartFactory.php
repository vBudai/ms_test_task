<?php

namespace App\Factory;

use App\Entity\Cart;
use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Cart>
 */
final class CartFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Cart::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'relatedUser' => UserFactory::new(),
        ];
    }

    public function createForUser(User $user): Cart
    {
        $cart = new Cart();
        $cart->setRelatedUser($user);

        return $cart;
    }

}
