<?php

namespace App\Controller;

use App\DTO\Request\Cart\CartProductRequest;
use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class CartsController extends AbstractController
{
    public function __construct(
        private readonly CartServiceInterface $service
    ){}

    #[Route('/api/carts/product', name: 'api_carts_add_product', methods: ['POST'])]
    public function addProduct(
        #[MapRequestPayload]
        CartProductRequest $request,
    ): Response
    {
        $this->service->addProduct($request);
        return $this->json(['msg' => 'Product has been added to cart']);
    }

    #[Route('/api/carts/product', name: 'api_carts_remove_product', methods: ['DELETE'])]
    public function removeProduct(
        #[MapRequestPayload]
        CartProductRequest $request,
    ): Response
    {
        $this->service->removeProduct($request);
        return $this->json(['msg' => 'Product has been removed to cart']);
    }

    #[Route('/api/carts/clear', name: 'api_carts_clear', methods: ['DELETE'])]
    public function clearCart(): Response
    {
        $this->service->clearCart();
        return $this->json(['msg' => 'Cart has been cleared']);
    }
}
