<?php

declare(strict_types=1);

namespace App\Acme\Discount;

use App\Acme\Entities\BasketItem;
use Override;

class SecondHalfPriceDiscountRule implements DiscountRuleInterface
{
    /**
     * The discount percentage for the second item.
     */
    private const float DISCOUNT_PERCENTAGE = 0.5;

    /**
     * Constructor.
     *
     * @param array $applicableProductCodes
     */
    public function __construct(
        private readonly array $applicableProductCodes
    ) {
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function calculateDiscount(BasketItem $item): float
    {
        if (!$this->isApplicable($item)) {
            return 0;
        }

        $discountedQuantity = intdiv($item->getQuantity(), 2);

        return $discountedQuantity * $item->product->price * self::DISCOUNT_PERCENTAGE;
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function isApplicable(BasketItem $item): bool
    {
        return in_array($item->product->code, $this->applicableProductCodes, true)
            && $item->getQuantity() >= 2;
    }
}
