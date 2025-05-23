<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Delivery;

use App\Acme\Delivery\DeliveryCalculator;
use App\Acme\Delivery\DeliveryRule;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeliveryCalculatorTest extends TestCase
{
    #[Test]
    #[DataProvider('basketAmountDataProvider')]
    public function calculate_should_return_delivery_amount(
        float $amount,
        float $delivery
    ): void {
        $calculator = new DeliveryCalculator([
            new DeliveryRule(50, 4.95),
            new DeliveryRule(90, 2.95),
            new DeliveryRule(90.01, 0),
        ]);

        $result = $calculator->calculate($amount);

        self::assertEquals($delivery, $result);
    }

    public static function basketAmountDataProvider(): array
    {
        return [
            'amount is negative' => [
                'amount' => -1,
                'delivery' => 4.95,
            ],
            'amount is 0' => [
                'amount' => 0,
                'delivery' => 4.95,
            ],
            'amount is 50' => [
                'amount' => 50,
                'delivery' => 4.95,
            ],
            'amount is 90' => [
                'amount' => 90,
                'delivery' => 2.95,
            ],
            'amount is 90.01' => [
                'amount' => 90.01,
                'delivery' => 0,
            ],
            'amount is 100' => [
                'amount' => 100,
                'delivery' => 0,
            ],
        ];
    }
}
