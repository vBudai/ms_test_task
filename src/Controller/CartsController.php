<?php

namespace App\Controller;

use App\DTO\Request\Cart\CartProductRequest;
use App\Exception\Cart\CartItemNotFoundException;
use App\Exception\User\UserNotAuthenticatedException;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class CartsController extends AbstractController
{
    public function __construct(
        private readonly CartService $service
    ){}


    /**
     * @throws UserNotAuthenticatedException
     */
    #[Route('/api/carts/product', name: 'api_carts_add_product', methods: ['POST'], format: 'json')]
    public function addProduct(
        #[MapRequestPayload]
        CartProductRequest $request,
    ): JsonResponse
    {
        $cartItem = $this->service->addProduct($request);
        return $this->json([ 'status' => 'success', 'data' => $cartItem ]);
    }

    /**
     * @throws UserNotAuthenticatedException
     * @throws CartItemNotFoundException
     */
    #[Route('/api/carts/product', name: 'api_carts_remove_product', methods: ['DELETE'], format: 'json')]
    public function removeProduct(
        #[MapRequestPayload]
        CartProductRequest $request,
    ): JsonResponse
    {
        $this->service->removeProduct($request);
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @throws UserNotAuthenticatedException
     */
    #[Route('/api/carts/clear', name: 'api_carts_clear', methods: ['DELETE'], format: 'json')]
    public function clearCart(): JsonResponse
    {
        $this->service->clearCart();
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
