<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Discount;

use App\Acme\Discount\SecondHalfPriceDiscountRule;
use App\Acme\Entities\BasketItem;
use App\Acme\Entities\Product;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SecondHalfPriceDiscountRuleTest extends TestCase
{
    #[Test]
    public function is_application_should_return_true_if_condition_is_respected(): void
    {
        $rule = new SecondHalfPriceDiscountRule(['1', '2']);
        $basketItemOne = new BasketItem(
            new Product('A', '1', 1),
            2
        );
        $basketItemTwo = new BasketItem(
            new Product('A', '1', 1),
            1
        );
        $basketItemThree = new BasketItem(
            new Product('C', '3', 1),
            2
        );

        $resultOne = $rule->isApplicable($basketItemOne);
        $resultTwo = $rule->isApplicable($basketItemTwo);
        $resultThree = $rule->isApplicable($basketItemThree);

        self::assertTrue($resultOne);
        self::assertFalse($resultTwo);
        self::assertFalse($resultThree);
    }

    #[Test]
    public function calculate_discount_should_return_zero_if_discount_is_not_applicable(): void
    {
        $rule = new SecondHalfPriceDiscountRule(['1', '2']);
        $basketItem = new BasketItem(
            new Product('A', '1', 1),
            1
        );

        $result = $rule->calculateDiscount($basketItem);

        self::assertEquals(0, $result);
    }

    #[Test]
    public function calculate_discount_should_return_discount_when_discount_is_applicable(): void
    {
        $rule = new SecondHalfPriceDiscountRule(['1', '2']);
        $basketItem = new BasketItem(
            new Product('A', '1', 10),
            2
        );

        $result = $rule->calculateDiscount($basketItem);

        self::assertEquals(5, $result);
    }
}
