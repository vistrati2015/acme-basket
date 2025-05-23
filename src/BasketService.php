<?php

declare(strict_types=1);

namespace App\Acme;

use App\Acme\Delivery\DeliveryCalculatorInterface;
use App\Acme\Discount\DiscountCalculatorInterface;
use App\Acme\Entities\Basket;
use App\Acme\Entities\BasketItem;
use App\Acme\ProductCatalog\ProductCatalogInterface;

class BasketService
{
    private Basket $basket;

    /**
     * Constructor.
     *
     * @param ProductCatalogInterface $productCatalog
     * @param DeliveryCalculatorInterface $deliveryCalculator
     * @param DiscountCalculatorInterface $discountCalculator
     */
    public function __construct(
        private readonly ProductCatalogInterface $productCatalog,
        private readonly DeliveryCalculatorInterface $deliveryCalculator,
        private readonly DiscountCalculatorInterface $discountCalculator,
    ) {
        $this->basket = new Basket([]);
    }

    /**
     * Adds an item to the basket.
     *
     * @param string $productCode
     * @return void
     */
    public function addItem(string $productCode): void
    {
        $product = $this->productCatalog->findByCode($productCode);

        $this->basket->addItem(new BasketItem($product, 1));
    }

    /**
     * Calculates the total cost of the basket.
     *
     * @return float
     */
    public function calculateTotalCost(): float
    {
        $discount = $this->calculateDiscountedAmount();
        $itemsCost = $this->basket->getItemsCost();
        $amount = $itemsCost - $discount;
        $deliveryCost = $this->deliveryCalculator->calculate($amount);

        return round($amount + $deliveryCost, 2, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Calculates the total discount of the basket.
     *
     * @return float
     */
    private function calculateDiscountedAmount(): float
    {
        return $this->discountCalculator->calculate($this->basket);
    }
}
