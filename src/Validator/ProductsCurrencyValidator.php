<?php

namespace App\Validator;

use App\DTO\ProductCollectionDTO;
use App\Domain\Product\ProductInterface;
use DomainException;

class ProductsCurrencyValidator
{
    /**
     * @throws DomainException
     */
    public static function ensureSameCurrency(ProductCollectionDTO $productCollectionDTO): void
    {
        $products = $productCollectionDTO->products;
        if ([] === $products) {
            return;
        }

        $baseCurrency = $products[0]->getPrice()->getCurrency();
        if (array_any($products, fn (ProductInterface $p) => $p->getPrice()->getCurrency() !== $baseCurrency)) {
            throw new DomainException('Inconsistent currency detected.');
        }
    }
}
