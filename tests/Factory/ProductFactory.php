<?php

namespace App\Tests\Factory;

use App\Entity\Product;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Product::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'id'      => new UuidV7(),
            'cost'    => self::faker()->randomNumber(),
            'height'  => self::faker()->randomNumber(),
            'length'  => self::faker()->randomNumber(),
            'name'    => self::faker()->text(255),
            'tax'     => self::faker()->randomNumber(),
            'version' => self::faker()->randomNumber(),
            'weight'  => self::faker()->randomNumber(),
            'width'   => self::faker()->randomNumber(),
            'description' => self::faker()->text(255),
        ];
    }
}
