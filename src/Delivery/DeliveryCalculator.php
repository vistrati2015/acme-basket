<?php

declare(strict_types=1);

namespace App\Acme\Delivery;

use Override;

class DeliveryCalculator implements DeliveryCalculatorInterface
{
    /**
     * Constructor
     *
     * @param DeliveryRuleInterface[] $rules
     */
    public function __construct(
        private array $rules = [],
    ) {
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function calculate(float $amount): float
    {
        $rules = $this->reorderRules();

        $eligibleRules = array_filter(
            $rules,
            fn (DeliveryRuleInterface $rule) => $rule->isApplicable($amount)
        );
        $eligibleRules = array_values($eligibleRules);

        return $eligibleRules ? $eligibleRules[0]->getDeliveryCost() : 0;
    }

    /**
     * Reorders the rules based on the order amount in ascending order based on order amount.
     *
     * @return DeliveryRuleInterface[]
     */
    private function reorderRules(): array
    {
        usort($this->rules, function (DeliveryRuleInterface $a, DeliveryRuleInterface $b) {
            return $a->threshold <=> $b->threshold;
        });

        return $this->rules;
    }
}
