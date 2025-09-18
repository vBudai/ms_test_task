<?php

namespace App\Tests\Story;

use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use App\Tests\Factory\OrderFactory;
use App\Tests\Factory\OrderItemFactory;
use App\Tests\Factory\ProductFactory;
use App\Tests\Factory\UserFactory;
use Symfony\Component\Uid\UuidV7;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public static User $user;

    /** @var Product[] */
    public static array $products;

    /** @var OrderItem[] */
    public static array $orderItems;

    public function build(): void
    {
        self::$products = ProductFactory::createMany(2, function (int $i) {
            return match ($i) {
                1 => ['name' => 'Product A', 'cost' => 10],
                2 => ['name' => 'Product B', 'cost' => 20],
            };
        });

        self::$user = UserFactory::createOne([
            'id' => new UuidV7(),
        ]);

        $order = OrderFactory::createOne(['relatedUser' => self::$user]);

        self::$orderItems = OrderItemFactory::createMany(2, function (int $i) use ($order) {
            return [
                'relatedOrder' => $order,
                'product' => self::$products[$i - 1],
                'amount' => $i,
                'cost' => self::$products[$i - 1]->getCost(),
            ];
        });
    }
}
