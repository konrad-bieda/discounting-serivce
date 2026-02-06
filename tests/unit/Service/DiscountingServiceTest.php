<?php

namespace App\Tests\unit\Service;

use App\Domain\ValueObject\Price;
use App\DTO\ProductCollectionDTO;
use App\Domain\Discount\FixedDiscount;
use App\Domain\Discount\PercentageDiscount;
use App\Domain\Discount\VolumeDiscount;
use App\Domain\Product\Product;
use App\Service\DiscountingService;
use App\Validator\Product\ProductsValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DiscountingServiceTest extends TestCase
{
    #[DataProvider('applyDiscountsProvider')]
    public function testApplyDiscounts(array $discounts, ProductCollectionDTO $products, int $expectedTotal): void
    {
        // Arrange
        $validator = $this->createMock(ProductsValidatorInterface::class);
        $validator->expects($this->once())->method('validate');
        $service = new DiscountingService([$validator], ...$discounts);

        // Act & Assert
        $this->assertSame($expectedTotal, $service->applyDiscounts($products));
    }

    public static function applyDiscountsProvider(): array
    {
        return [
            'all discounts should apply' => [
                [
                    new FixedDiscount(10, 'PLN', ['code1']),
                    new PercentageDiscount(10),
                    new VolumeDiscount(10, 'PLN', 1)
                ],
                new ProductCollectionDTO(
                    ...[
                        new Product('code1', new Price(50, 'PLN'), 1)
                    ]
                ),
                25
            ],
            'some discounts should be applied #1' => [
                [
                    new FixedDiscount(25, 'PLN', ['code1']),
                    new FixedDiscount(30, 'PLN', ['code2']),
                    new PercentageDiscount(50),
                    new VolumeDiscount(50, 'PLN', 10)
                ],
                new ProductCollectionDTO(
                    ...[
                        new Product('code1', new Price(20, 'PLN'), 15),
                        new Product('code2', new Price(100, 'PLN'), 5),
                        new Product('code3', new Price(50, 'PLN'), 1)
                    ]
                ),
                320
            ],
            'some discounts should be applied #2' => [
                [
                    new FixedDiscount(25, 'PLN', ['code1']),
                    new FixedDiscount(30, 'PLN', ['code2']),
                    new PercentageDiscount(50),
                    new VolumeDiscount(50, 'PLN', 10),
                    new PercentageDiscount(10),
                    new FixedDiscount(2, 'PLN', ['code3']),
                    new FixedDiscount(100, 'PLN', ['code3']),
                    new VolumeDiscount(50, 'PLN', 1),
                    new VolumeDiscount(50, 'EUR', 5),
                ],
                new ProductCollectionDTO(
                    ...[
                        new Product('code1', new Price(20, 'EUR'), 15),
                        new Product('code2', new Price(100, 'EUR'), 5),
                        new Product('code3', new Price(200, 'EUR'), 1)
                    ]
                ),
                300
            ],
        ];
    }
}
