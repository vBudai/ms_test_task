<?php

namespace App\Factory;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;

final readonly class CartItemFactory
{
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
