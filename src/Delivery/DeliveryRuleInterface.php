<?php

namespace App\Acme\Delivery;

interface DeliveryRuleInterface
{
    /**
     * Checks if the rule is applicable based on the order amount.
     *
     * @param float $orderAmount
     * @return bool $deliveryCost
     */
    public function isApplicable(float $orderAmount): bool;

    /**
     * Returns the delivery cost.
     *
     * @return float
     */
    public function getDeliveryCost(): float;
}
