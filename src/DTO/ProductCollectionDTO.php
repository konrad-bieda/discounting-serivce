<?php

namespace App\DTO;

use App\Domain\Product\ProductInterface;

readonly class ProductCollectionDTO
{
    /** @var ProductInterface[] */
    public array $products;

    public function __construct(
        ProductInterface ...$products,
    ) {
        $this->products = $products;
    }
}
