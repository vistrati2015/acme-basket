<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit;

use App\Acme\BasketService;
use App\Acme\Delivery\DeliveryCalculator;
use App\Acme\Discount\DiscountCalculator;
use App\Acme\Entities\Product;
use App\Acme\ProductCatalog\ProductCatalog;
use Override;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BasketServiceTest extends TestCase
{
    #[Override]
    public function tearDown(): void
    {
        parent::tearDown();
    }

    #[Test]
    public function add_item_should_add_product_to_basket(): void
    {
        $productCatalog = $this->createMock(ProductCatalog::class);
        $productCatalog->method('findByCode')
            ->with('A')
            ->willReturn($product = new Product('A', '1', 1));
        $discountCalculator = $this->createMock(DiscountCalculator::class);
        $deliveryCalculator = $this->createMock(DeliveryCalculator::class);

        $basketService = new BasketService(
            $productCatalog,
            $deliveryCalculator,
            $discountCalculator,
        );

        $basketService->addItem('A');
    }

    #[Test]
    public function calculate_total_cost_should_return_basket_cost_with_delivery_and_deducted_discount(): void
    {
        $productCatalog = $this->createMock(ProductCatalog::class);
        $productCatalog->method('findByCode')
            ->willReturn(new Product('A', '1', 1));
        $discountCalculator = $this->createMock(DiscountCalculator::class);
        $discountCalculator->method('calculate')
            ->willReturn(0.0);
        $deliveryCalculator = $this->createMock(DeliveryCalculator::class);
        $deliveryCalculator->method('calculate')
            ->willReturn(4.95);

        $basketService = new BasketService(
            $productCatalog,
            $deliveryCalculator,
            $discountCalculator,
        );

        $basketService->addItem('A');
        $basketService->addItem('B');

        self::assertEquals(6.95, $basketService->calculateTotalCost());
    }
}
