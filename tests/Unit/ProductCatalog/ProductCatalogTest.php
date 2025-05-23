<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\ProductCatalog;

use App\Acme\Entities\Product;
use App\Acme\Exceptions\ProductNotFound;
use App\Acme\ProductCatalog\ProductCatalog;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProductCatalogTest extends TestCase
{
    #[Test]
    public function it_should_throw_an_exception_when_items_are_not_type_of_an_array(): void
    {
        self::expectException(InvalidArgumentException::class);

        new ProductCatalog([
            new Product('A', '1', 1),
            'invalid_item_1',
        ]);
    }

    #[Test]
    public function it_should_find_product_by_code_and_return_it(): void
    {
        $productCatalog = new ProductCatalog([
            new Product('A', '1', 1),
            new Product('B', '2', 2),
            new Product('C', '3', 3),
        ]);

        $product = $productCatalog->findByCode('2');

        self::assertInstanceOf(Product::class, $product);
        self::assertEquals('B', $product->name);
        self::assertEquals('2', $product->code);
    }

    #[Test]
    public function it_should_return_product_not_found_exception_when_is_missing(): void
    {
        $productCatalog = new ProductCatalog([
            new Product('A', '1', 1),
        ]);

        self::expectException(ProductNotFound::class);

        $productCatalog->findByCode('2');
    }
}
