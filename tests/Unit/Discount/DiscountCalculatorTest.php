<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Discount;

use App\Acme\Discount\DiscountCalculator;
use App\Acme\Discount\SecondHalfPriceDiscountRule;
use App\Acme\Entities\Basket;
use App\Acme\Entities\BasketItem;
use App\Acme\Entities\Product;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DiscountCalculatorTest extends TestCase
{
    #[Test]
    public function it_should_apply_discount_for_basket_items_where_is_respected(): void
    {
        $calculator = new DiscountCalculator([
            new SecondHalfPriceDiscountRule(['1', '2', '4']),
        ]);

        $basketItems = [
            new BasketItem(new Product('A', '1', 10), 2),
            new BasketItem(new Product('B', '2', 20), 2),
            new BasketItem(new Product('C', '3', 30), 2),
            new BasketItem(new Product('D', '4', 40), 1),
        ];

        $result = $calculator->calculate(new Basket($basketItems));

        self::assertEquals(15, $result);
    }
}
