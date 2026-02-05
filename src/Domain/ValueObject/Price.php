<?php

namespace App\Domain\ValueObject;

readonly class Price implements PriceInterface
{
    public function __construct(private int $amount, private string $currency)
    {
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
