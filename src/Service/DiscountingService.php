<?php

namespace App\Service;

use App\DTO\ProductCollectionDTO;
use App\Domain\Discount\DiscountInterface;
use App\Validator\ProductsCurrencyValidator;
use DomainException;

final readonly class DiscountingService
{
    /** @var DiscountInterface[] */
    private array $discounts;

    public function __construct(DiscountInterface ...$discounts)
    {
        $this->discounts = $discounts;
    }

    /**
     * @throws DomainException
     */
    public function applyDiscounts(ProductCollectionDTO $productCollectionDTO): int
    {
        ProductsCurrencyValidator::ensureSameCurrency($productCollectionDTO);

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
