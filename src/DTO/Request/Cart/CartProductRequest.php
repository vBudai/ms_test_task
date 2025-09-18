<?php

namespace App\DTO\Request\Cart;

use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

class CartProductRequest
{
    public function __construct(
        #[Assert\Sequentially([
            new Assert\Uuid(),
            new AppAssert\ProductExists(),
        ])]
        public string $productId,
    ) {
    }
}
