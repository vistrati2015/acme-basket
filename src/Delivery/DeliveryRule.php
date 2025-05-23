<?php

declare(strict_types=1);

namespace App\Acme\Delivery;

use InvalidArgumentException;
use Override;

class DeliveryRule implements DeliveryRuleInterface
{
    /**
     * Constructor
     *
     * @param float $threshold
     * @param float $deliveryCost
     */
    public function __construct(
        public readonly float $threshold,
        public readonly float $deliveryCost,
    ) {
        $this->validate($this->threshold, $this->deliveryCost);
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function isApplicable(float $orderAmount): bool
    {
        return $orderAmount <= $this->threshold;
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function getDeliveryCost(): float
    {
        return $this->deliveryCost;
    }

    /**
     * Validates the threshold and delivery cost.
     *
     * @throws InvalidArgumentException
     */
    private function validate(float $threshold, float $deliveryCost): void
    {
        if ($threshold < 0) {
            throw new InvalidArgumentException('Threshold must be a positive number.');
        }
        if ($deliveryCost < 0) {
            throw new InvalidArgumentException('Delivery cost must be a positive number.');
        }
    }
}
