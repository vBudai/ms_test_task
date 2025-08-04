<?php

namespace App\DTO\Request\Order;

use App\Enum\Order\OrderDeliveryType;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

class CreateOrderRequest
{
    public function __construct(
        #[AppAssert\Phone]
        public string $phone,

        #[Assert\Choice(
            callback: [OrderDeliveryType::class, 'values'],
            message: 'Недопустимый тип доставки'
        )]
        public string $deliveryType,

        #[Assert\All([
            new Assert\Uuid(message: 'Product ID must be valid UUID'),
            new AppAssert\CartItemExists(),
        ])]
        public array $cartItems,
    ) {
    }
}
