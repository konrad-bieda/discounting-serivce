<?php

namespace App\Validator\Product;

use App\Domain\Product\ProductInterface;
use App\DTO\ProductCollectionDTO;
use DomainException;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem('app.products_validator')]
class ProductsCurrencyValidator implements ProductsValidatorInterface
{
    /**
     * @throws DomainException
     */
    public function validate(ProductCollectionDTO $productCollectionDTO): void
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
