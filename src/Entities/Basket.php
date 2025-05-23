<?php

declare(strict_types=1);

namespace App\Acme\Entities;

use InvalidArgumentException;

class Basket
{
    /**
     * Constructor.
     *
     * @param BasketItem[] $items
     */
    public function __construct(
        private array $items
    ) {
        $this->validate($this->items);
    }

    /**
     * Gets the total cost of the items in the basket.
     *
     * @return float
     */
    public function getItemsCost(): float
    {
        return array_reduce(
            $this->items,
            fn (float $cost, BasketItem $item) => $cost + ($item->product->price * $item->getQuantity()),
            0
        );
    }

    /**
     * Adds an item to the basket or update quantity if item is present.
     *
     * @param BasketItem $basketItem
     * @return void
     */
    public function addItem(BasketItem $basketItem): void
    {
        $existingBasketItem = $this->findItemByProductCode($basketItem->product->code);

        if ($existingBasketItem) {
            $existingBasketItem->incrementQuantity();
        } else {
            $this->items[] = $basketItem;
        }
    }

    /**
     * Finds an item in the basket by product code.
     *
     * @param string $productCode
     * @return BasketItem|null
     */
    private function findItemByProductCode(string $productCode): ?BasketItem
    {
        $filteredItems = array_filter(
            $this->items,
            fn (BasketItem $basketItem) => $basketItem->product->code === $productCode
        );
        $reset = array_values($filteredItems ?? []);

        return count($reset) > 0 ? $reset[0] : null;
    }

    /**
     * Gets the items in the basket.
     *
     * @return BasketItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Validates the items in the basket.
     *
     * @param array $items
     * @throws InvalidArgumentException
     */
    private function validate(array $items): void
    {
        $count = count($items);

        for ($i = 0; $i < $count; ++$i) {
            if (!$items[$i] instanceof BasketItem) {
                throw new InvalidArgumentException('Invalid item in basket');
            }
        }
    }
}
