<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Entities;

use App\Acme\Entities\Product;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    #[Test]
    public function it_should_create_product_instance_when_all_parameters_are_valid(): void
    {
        $product = new Product('A', '1', 1);

        self::assertInstanceOf(Product::class, $product);
        self::assertEquals('A', $product->name);
        self::assertEquals('1', $product->code);
        self::assertEquals(1, $product->price);
    }

    #[Test]
    #[DataProvider('invalidProductDataProvider')]
    public function it_should_throw_an_exception_when_parameters_are_invalid(
        string $name,
        string $code,
        float $price,
    ): void {
        self::expectException(InvalidArgumentException::class);

        new Product($name, $code, $price);
    }

    public static function invalidProductDataProvider(): array
    {
        return [
            'empty name' => [
                'name' => '',
                'code' => '1',
                'price' => 1,
            ],
            'empty code' => [
                'name' => 'A',
                'code' => '',
                'price' => 1,
            ],
            'negative price' => [
                'name' => 'A',
                'code' => '1',
                'price' => -1,
            ],
        ];
    }
}
