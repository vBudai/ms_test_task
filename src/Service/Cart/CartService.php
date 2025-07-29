<?php

namespace App\Service\Cart;

use App\DTO\Request\Cart\CartProductRequest;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\User;
use App\Exception\Cart\CartItemNotFoundException;
use App\Exception\User\UserNotAuthenticatedException;
use App\Factory\CartFactory;
use App\Factory\CartItemFactory;
use App\Repository\CartItemRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\User\UserProvider;

readonly class CartService
{
    public function __construct(
        private CartRepository     $cartRepo,
        private CartItemRepository $cartItemRepo,
        private ProductRepository  $productRepo,

        private CartFactory     $cartFactory,
        private CartItemFactory $cartItemFactory,

        private UserProvider       $userProvider,
    ){
    }

    public function createCartForUser(User $user): Cart
    {
        $cart = $this->cartRepo->findOneBy(['relatedUser' => $user]);
        if($cart !== null){
            return $cart;
        }

        $cart = $this->cartFactory->createForUser($user);
        $this->cartRepo->add($cart, true);

        return $cart;
    }

    /**
     * @throws UserNotAuthenticatedException
     */
    public function addProduct(CartProductRequest $request): CartItem
    {
        $user = $this->userProvider->getUser();
        $cart = $user->getCart();

        $product = $this->productRepo->find($request->productId);

        $cartItem = $this->cartItemRepo->findOneBy([
            'product' => $product,
            'cart'    => $cart,
        ]) ?? $this->cartItemFactory->createForProduct($product, $cart);

        $cartItem->incrementAmount();
        $this->cartItemRepo->add($cartItem, true);

        return $cartItem;
    }

    /**
     * @throws UserNotAuthenticatedException
     * @throws CartItemNotFoundException
     */
    public function removeProduct(CartProductRequest $request): void
    {
        $user = $this->userProvider->getUser();
        $cart = $user->getCart();

        $product = $this->productRepo->find($request->productId);

        $cartItem = $this->cartItemRepo->findOneBy([
            'product' => $product,
            'cart'    => $cart,
        ]);
        if($cartItem === null){
            throw new CartItemNotFoundException();
        }

        if($cartItem->getAmount() === 1){
            $this->cartItemRepo->remove($cartItem, true);
        }
        else{
            $cartItem->decrementAmount();
            $this->cartItemRepo->add($cartItem, true);
        }
    }

    /**
     * @throws UserNotAuthenticatedException
     */
    public function clearCart(): void
    {
        $user = $this->userProvider->getUser();
        $this->cartItemRepo->clearCartItems($user->getCart());
    }
}
