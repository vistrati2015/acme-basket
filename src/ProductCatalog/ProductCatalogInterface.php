<?php

declare(strict_types=1);

namespace App\Acme\ProductCatalog;

use App\Acme\Entities\Product;
use App\Acme\Exceptions\ProductNotFound;

interface ProductCatalogInterface
{
    /**
     * Find a product by its code. If the product is not found, an exception is thrown.
     *
     * @param string $code
     * @return Product
     * @throws ProductNotFound
     */
    public function findByCode(string $code): Product;
}
