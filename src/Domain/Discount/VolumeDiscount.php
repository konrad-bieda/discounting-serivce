<?php

namespace App\Domain\Discount;

use App\Domain\Product\ProductInterface;

final readonly class VolumeDiscount extends Discount
{
    public function __construct(
        private int $value,
        private string $currency,
        private int $minQuantity,
        ?array $productCodes = null,
    ) {
        parent::__construct($productCodes);
    }

    public function supports(ProductInterface $product): bool
    {
        $supports = parent::supports($product);

        return $supports
            && $product->getQuantity() >= $this->minQuantity
            && $this->currency === $product->getPrice()->getCurrency();
    }

    public function calculate(ProductInterface $product): int
    {
        return $this->value;
    }
}
