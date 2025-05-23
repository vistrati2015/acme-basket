<?php

declare(strict_types=1);

namespace App\Acme\ProductCatalog;

use App\Acme\Entities\Product;
use App\Acme\Exceptions\ProductNotFound;
use InvalidArgumentException;
use Override;

class ProductCatalog implements ProductCatalogInterface
{
    /**
     * Constructor
     *
     * @param Product[] $products
     */
    public function __construct(
        private readonly array $products = [],
    ) {
        $this->validate($this->products);
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function findByCode(string $code): Product
    {
        $products = array_filter(
            $this->products,
            fn (Product $product) => $product->code === $code
        );
        $reset = array_values($products ?? []);


        $product = $reset[0] ?? null;

        if (!$product) {
            throw new ProductNotFound("Product with code $code not found.");
        }

        return $product;
    }

    /**
     * Validates the products in the catalog.
     *
     * @param array $items
     * @throws InvalidArgumentException
     */
    private function validate(array $items): void
    {
        $count = count($items);

        for ($i = 0; $i < $count; ++$i) {
            if (!$items[$i] instanceof Product) {
                throw new InvalidArgumentException('Invalid item in catalog');
            }
        }
    }
}
