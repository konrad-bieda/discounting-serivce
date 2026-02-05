<?php

namespace App\Domain\Discount;

use App\Domain\Product\ProductInterface;

final readonly class PercentageDiscount extends Discount
{
    public function __construct(
        private int $percentage,
        ?array $productCodes = null
    ) {
        parent::__construct($productCodes);
    }

    public function calculate(ProductInterface $product): int
    {
        return (int) round(
            $product->getPrice()->getAmount() * $product->getQuantity() * $this->percentage / 100,
            PHP_ROUND_HALF_DOWN
        );
    }
}
