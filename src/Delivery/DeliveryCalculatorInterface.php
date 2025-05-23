<?php

declare(strict_types=1);

namespace App\Acme\Delivery;

interface DeliveryCalculatorInterface
{
    /**
     * Calculate the delivery cost based on the given amount.
     *
     * @param float $amount
     * @return float
     */
    public function calculate(float $amount): float;
}
