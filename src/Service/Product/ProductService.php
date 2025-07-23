<?php

namespace App\Service\Product;

use App\Repository\ProductRepository;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepository $repo
    ){}

    public function getAllProducts(): array
    {
        return $this->repo->findAll();
    }
}
