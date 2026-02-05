<?php

namespace App\Domain\Product;

use App\Domain\ValueObject\PriceInterface;

interface ProductInterface
{
    public function getCode(): string;

    public function getPrice(): PriceInterface;

    public function getQuantity(): int;
}
