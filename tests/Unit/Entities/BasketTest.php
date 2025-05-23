<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Entities;

use App\Acme\Entities\Basket;
use App\Acme\Entities\BasketItem;
use App\Acme\Entities\Product;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    #[Test]
    public function it_should_create_a_basket_instance_when_it_provided_and_valid_array_of_items(): void
    {
        $basketItem = new BasketItem(new Product('A', '1', 1), 1);
        $basket = new Basket([$basketItem]);

        self::assertInstanceOf(Basket::class, $basket);
        self::assertCount(1, $basket->getItems());
    }

    #[Test]
    public function it_should_throw_an_exception_when_items_contains_invalid_item(): void
    {
        self::expectException(InvalidArgumentException::class);

        new Basket(['dummy']);
    }

    #[Test]
    public function _it_should_return_total_items_cost(): void
    {
        $basketItem1 = new BasketItem(new Product('A', '1', 1), 2);
        $basketItem2 = new BasketItem(new Product('B', '2', 2), 3);

        $basket = new Basket([$basketItem1, $basketItem2]);

        $totalCost = $basket->getItemsCost();

        self::assertEquals(8, $totalCost);
    }
}
