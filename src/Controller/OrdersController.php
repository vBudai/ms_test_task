<?php

namespace App\Controller;

use App\DTO\Request\Order\CreateOrderRequest;
use App\Service\Order\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class OrdersController extends AbstractController
{
    public function __construct(
        private OrderService $orderService
    ){}

    #[Route('/api/orders', name: 'api_create_order', methods: ['POST'], format: 'json')]
    public function createOrder(
        #[MapRequestPayload]
        CreateOrderRequest $request,
    ): JsonResponse
    {
        $order = $this->orderService->createOrder($request);
        return $this->json(['status' => 'success', 'data' => $order]);
    }
}
