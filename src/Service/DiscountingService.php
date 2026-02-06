<?php

namespace App\Service;

use App\Domain\Discount\DiscountInterface;
use App\DTO\ProductCollectionDTO;
use App\Validator\Product\ProductsValidatorInterface;
use DomainException;

final readonly class DiscountingService
{
    /** @var DiscountInterface[] */
    private array $discounts;

    /**
     * @param iterable<ProductsValidatorInterface> $productsValidators
     */
    public function __construct(
        public iterable $productsValidators,
        DiscountInterface ...$discounts,
    ) {
        $this->discounts = $discounts;
    }

    /**
     * @throws DomainException
     */
    public function applyDiscounts(ProductCollectionDTO $productCollectionDTO): int
    {
        foreach ($this->productsValidators as $validator) {
            $validator->validate($productCollectionDTO);
        }

        $total = 0;
        foreach ($productCollectionDTO->products as $product) {
            $itemTotal = $product->getPrice()->getAmount() * $product->getQuantity();

            foreach ($this->discounts as $discount) {
                if (!$discount->supports($product)) {
                    continue;
                }

                $itemTotal -= $discount->calculate($product);
            }

            $total += max(0, $itemTotal);
        }

        return $total;
    }
}
