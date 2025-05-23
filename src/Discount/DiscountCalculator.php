<?php

declare(strict_types=1);

namespace App\Acme\Discount;

use App\Acme\Entities\Basket;
use App\Acme\Entities\BasketItem;
use Override;

class DiscountCalculator implements DiscountCalculatorInterface
{
    /**
     * Constructor
     *
     * @param DiscountRuleInterface[] $rules
     */
    public function __construct(
        private readonly array $rules,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function calculate(Basket $basket): float
    {
        $totalDiscount = 0;

        $items = $basket->getItems();
        $itemsCount = count($items);

        for ($i = 0; $i < $itemsCount; ++$i) {
            $totalDiscount += $this->calculateItemDiscount($items[$i]);
        }

        return $totalDiscount;
    }

    /**
     * Calculates the discount for a single item.
     *
     * @param BasketItem $item
     * @return float
     */
    private function calculateItemDiscount(BasketItem $item): float
    {
        $maxDiscount = 0;

        $rulesCount = count($this->rules);

        for ($i = 0; $i < $rulesCount; ++$i) {
            if ($this->rules[$i]->isApplicable($item)) {
                $discount = $this->rules[$i]->calculateDiscount($item);
                $maxDiscount = max($maxDiscount, $discount);
            }
        }

        return $maxDiscount;
    }
}
