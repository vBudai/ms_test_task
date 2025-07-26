<?php

namespace App\Factory;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
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

    public function createForProduct(Product $product, Cart $cart): CartItem
    {
        $cartItem = new CartItem();
        $cartItem
            ->setProduct($product)
            ->setAmount(0)
            ->setCart($cart);

        return $cartItem;
    }
}
