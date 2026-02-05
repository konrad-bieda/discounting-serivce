<?php

namespace App\Domain\ValueObject;

interface PriceInterface
{
    public function getAmount(): int;

    public function getCurrency(): string;
}
