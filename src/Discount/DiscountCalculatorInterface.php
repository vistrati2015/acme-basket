<?php

declare(strict_types=1);

namespace App\Acme\Discount;

use App\Acme\Entities\Basket;

interface DiscountCalculatorInterface
{
    /**
     * Calculate the total discount for the given basket.
     *
     * @param Basket $basket
     * @return float
     */
    public function calculate(Basket $basket): float;
}
