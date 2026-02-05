<?php

namespace App\Domain\Discount;

use App\Domain\Product\ProductInterface;

abstract readonly class Discount implements DiscountInterface
{
    /** @param string[] $productCodes */
    public function __construct(
        protected ?array $productCodes = null
    ) {
    }

    public function supports(ProductInterface $product): bool
    {
        if (null === $this->productCodes) {
            return true;
        }

        return in_array($product->getCode(), $this->productCodes, true);
    }
}
