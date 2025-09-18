<?php

namespace App\Tests\Factory;

use App\Entity\CartItem;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<CartItem>
 */
final class CartItemFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return CartItem::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'amount' => self::faker()->numberBetween(1, 32767),
            'cart' => CartFactory::new(),
            'product' => ProductFactory::new(),
        ];
    }
}
