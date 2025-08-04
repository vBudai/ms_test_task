<?php

namespace App\Tests\Factory;

use App\Entity\Order;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Order>
 */
final class OrderFactory extends PersistentProxyObjectFactory
{

    public static function class(): string
    {
        return Order::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array|callable
    {
        return [
            'deliveryType' => self::faker()->text(16),
            'phone' => self::faker()->text(16),
            'relatedUser' => null, // TODO add App\Entity\User type manually
            'status' => self::faker()->text(32),
        ];
    }
}
