<?php

namespace App\Domain\Discount;

use App\Domain\Product\ProductInterface;

interface DiscountInterface
{
    public function supports(ProductInterface $product): bool;

    public function calculate(ProductInterface $product): int;
}
