<?php

declare(strict_types=1);

namespace App\Acme\Discount;

use App\Acme\Entities\BasketItem;

interface DiscountRuleInterface
{
    /**
     * Check if the discount rule is applicable to the given basket item.
     *
     * @param BasketItem $item
     * @return bool
     */
    public function isApplicable(BasketItem $item): bool;

    /**
     * Calculate the discount for the given basket item.
     *
     * @param BasketItem $item
     * @return float
     */
    public function calculateDiscount(BasketItem $item): float;
}
