<?php

namespace App\Controller;

use App\Service\Product\ProductService;
use App\Service\Product\ProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductsController extends AbstractController
{

    public function __construct(
        private readonly ProductServiceInterface $service
    ){}

    #[Route('/api/products', name: 'api_products_get_all', methods: ['GET'])]
    public function getAll(): Response
    {
        return $this->json([$this->service->getAllProducts()], Response::HTTP_OK);
    }
}
