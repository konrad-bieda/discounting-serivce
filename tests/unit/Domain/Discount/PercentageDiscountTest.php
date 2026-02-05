<?php

namespace App\Tests\unit\Domain\Discount;

use App\Domain\ValueObject\Price;
use App\Domain\Discount\PercentageDiscount;
use App\Domain\Product\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PercentageDiscountTest extends TestCase
{
    public function testSupports(): void
    {
        // Arrange
        $product = new Product('code', new Price(100, 'PLN'), 1);
        $discount = new PercentageDiscount(1);

        // Act & Assert
        $this->assertTrue($discount->supports($product));
    }

    #[DataProvider('calculateProvider')]
    public function testCalculate(int $productPrice, int $discountPercentage, int $expectedResult): void
    {
        //Arrange
        $product = new Product('code', new Price($productPrice, 'PLN'), 1);
        $discount = new PercentageDiscount($discountPercentage);

        // Act & Assert
        $this->assertSame($expectedResult, $discount->calculate($product));
    }

    public static function calculateProvider(): array
    {
        return [
            [100, 15, 15],
            [261, 50, 130],
        ];
    }
}
