<?php

namespace App\Domain\Discount;

use App\Domain\Product\ProductInterface;

final readonly class FixedDiscount extends Discount
{
    public function __construct(
        private int $value,
        private string $currency,
        ?array $productCodes = null
    ) {
        parent::__construct($productCodes);
    }

    public function supports(ProductInterface $product): bool
    {
        $supports = parent::supports($product);

        return $supports && $this->currency === $product->getPrice()->getCurrency();
    }

    public function calculate(ProductInterface $product): int
    {
        return $this->value;
    }
}
