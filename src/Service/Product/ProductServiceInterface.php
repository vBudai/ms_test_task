<?php

namespace App\Service\Product;

use App\Entity\Product;

interface ProductServiceInterface
{
    /**
     * @return Product[]
     */
    public function getAllProducts(): array;
}
