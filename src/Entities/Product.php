<?php

declare(strict_types=1);

namespace App\Acme\Entities;

use InvalidArgumentException;

class Product
{
    /**
     * Constructor
     *
     * @param string $name
     * @param string $code
     * @param float $price
     */
    public function __construct(
        public readonly string $name,
        public readonly string $code,
        public readonly float $price,
    ) {
        $this->validate($this->name, $this->code, $this->price);
    }

    /**
     * Validate the product properties.
     *
     * @throws InvalidArgumentException
     */
    private function validate(
        string $name,
        string $code,
        float $price,
    ): void {
        if (empty($name)) {
            throw new InvalidArgumentException('Product name cannot be empty');
        }
        if (empty($code)) {
            throw new InvalidArgumentException('Product code cannot be empty');
        }
        if ($price < 0) {
            throw new InvalidArgumentException('Product price cannot be negative');
        }
    }
}
