<?php

namespace App\Service\Cart;


use App\DTO\Request\Cart\CartProductRequest;
use App\Entity\User;

interface CartServiceInterface
{
    public function createForUser(User $user): void;
    public function addProduct(CartProductRequest $request): void;
    public function removeProduct(CartProductRequest $request): void;
    public function clearCart(): void;
}
