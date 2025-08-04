<?php

namespace App\Controller;

use App\Service\Product\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ProductsController extends AbstractController
{
    public function __construct(
        private readonly ProductService $service,
    ) {
    }

    #[Route('/api/products', name: 'api_products_get_all', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        return $this->json($this->service->getAllProducts());
    }
}
