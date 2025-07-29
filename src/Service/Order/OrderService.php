<?php

namespace App\Service\Order;

use App\DTO\Request\Order\CreateOrderRequest;
use App\Entity\Order;
use App\Enum\Order\OrderStatus;

class OrderService
{

    public function createOrder(CreateOrderRequest $request): Order
    {
        return new Order();
    }

    public function changeOrderStatus(int $orderId, OrderStatus $newStatus): Order
    {
        return new Order();
    }
}
