<?php

namespace App\Service\Product;

use App\Repository\ProductRepository;

readonly class ProductService
{
    public function __construct(
        private ProductRepository $repo,
    ) {
    }

    public function getAllProducts(): array
    {
        return $this->repo->findAll();
    }
}
