<?php

namespace App\Tests\Factory;

use App\Entity\OrderItem;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<OrderItem>
 */
final class OrderItemFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return OrderItem::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'amount' => self::faker()->numberBetween(1, 32767),
            'cost' => self::faker()->randomNumber(),
            'product' => null, // TODO add App\Entity\Product type manually
            'relatedOrder' => null, // TODO add App\Entity\Order type manually
        ];
    }
}
