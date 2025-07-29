<?php

namespace App\Tests\Service\Product;

use App\Entity\Product;
use App\Tests\Factory\ProductFactory;
use App\Repository\ProductRepository;
use App\Service\Product\ProductService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ProductServiceTest extends KernelTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetAllProductsReturnsProductsArray(): void
    {
        $products = ProductFactory::createMany(5);

        $repo = self::getContainer()->get(ProductRepository::class);
        $productService = new ProductService($repo);

        $result = $productService->getAllProducts();
        $this->assertCount(count($products), $result);
        $this->assertContainsOnlyInstancesOf(Product::class, $result);
    }

    public function testGetAllProductsReturnsEmptyArray(): void
    {
        $repo = self::getContainer()->get(ProductRepository::class);
        $productService = new ProductService($repo);

        $result = $productService->getAllProducts();
        $this->assertCount(0, $result);
        $this->assertSame([], $result);
    }
}
