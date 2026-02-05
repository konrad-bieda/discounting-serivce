<?php

namespace App\Domain\Product;

use App\Domain\ValueObject\PriceInterface;

final readonly class Product implements ProductInterface
{
    public function __construct(
        private string $code,
        private PriceInterface $price,
        private int $quantity
    ) {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPrice(): PriceInterface
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
