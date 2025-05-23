<?php

declare(strict_types=1);

namespace App\Acme\Entities;

use InvalidArgumentException;

class BasketItem
{
    /**
     * BasketItem constructor.
     *
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(
        public readonly Product $product,
        private int $quantity,
    ) {
        $this->validate($this->quantity);
    }

    /**
     * Increment the quantity of the item in the basket.
     *
     * @param int $quantity
     * @throws InvalidArgumentException
     */
    public function incrementQuantity(int $quantity = 1): void
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }

        $this->quantity += $quantity;
    }

    /**
     * Get the quantity of the item in the basket.
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Validate the quantity.
     *
     * @param int $quantity
     * @throws InvalidArgumentException
     */
    private function validate(int $quantity): void
    {
        if ($quantity < 1) {
            throw new InvalidArgumentException('Quantity must be greater than 0');
        }
    }
}
