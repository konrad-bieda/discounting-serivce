<?php

namespace App\Factory;

use App\Domain\Discount\DiscountInterface;
use App\Service\DiscountingService;
use App\Validator\Product\ProductsValidatorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class DiscountingServiceFactory
{
    /**
     * @param iterable<ProductsValidatorInterface> $validators
     */
    public function __construct(
        #[AutowireIterator('app.products_validator')]
        private iterable $validators,
    ) {
    }

    public function create(DiscountInterface ...$discounts): DiscountingService
    {
        return new DiscountingService($this->validators, ...$discounts);
    }
}
