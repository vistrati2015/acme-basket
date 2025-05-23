<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Delivery;

use App\Acme\Delivery\DeliveryRule;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeliveryRuleTest extends TestCase
{
    #[Test]
    public function it_should_instantiate_rule_with_valid_parameters(): void
    {
        $rule = new DeliveryRule(1, 1);

        self::assertInstanceOf(DeliveryRule::class, $rule);
        self::assertEquals(1, $rule->threshold);
        self::assertEquals(1, $rule->deliveryCost);
    }

    #[Test]
    public function it_should_throw_an_exception_when_threshold_is_invalid(): void
    {
        self::expectException(InvalidArgumentException::class);

        new DeliveryRule(-1, 1);
    }

    #[Test]
    public function it_should_throw_an_exception_when_delivery_cost_is_invalid(): void
    {
        self::expectException(InvalidArgumentException::class);

        new DeliveryRule(1, -1);
    }

    #[Test]
    public function is_applicable_should_return_true_when_rule_is_applicable(): void
    {
        $rule = new DeliveryRule(1, 1);

        self::assertTrue($rule->isApplicable(1));
    }

    #[Test]
    public function is_applicable_should_return_true_when_rule_is_not_applicable(): void
    {
        $rule = new DeliveryRule(1, 1);

        self::assertFalse($rule->isApplicable(3));
    }
}
