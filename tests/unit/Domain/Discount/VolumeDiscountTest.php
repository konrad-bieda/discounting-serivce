<?php

namespace App\Tests\unit\Domain\Discount;

use App\Domain\ValueObject\Price;
use App\Domain\Discount\VolumeDiscount;
use App\Domain\Product\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VolumeDiscountTest extends TestCase
{
    #[DataProvider('supportsProvider')]
    public function testSupports(int $productQuantity, int $minQuantity, string $productCurrency, string $discountCurrency, bool $expected): void
    {
        // Arrange
        $product = new Product('code', new Price(100, $productCurrency), $productQuantity);
        $discount = new VolumeDiscount(1, $discountCurrency, $minQuantity);

        // Act & Assert
        $this->assertSame($expected, $discount->supports($product));
    }

    public function testCalculate(): void
    {
        // Arrange
        $discountValue = 100;
        $currency = 'PLN';
        $code = 'code';

        $product = new Product($code, new Price(100, $currency), 1);
        $discount = new VolumeDiscount($discountValue, $currency, 11);

        // Act & Assert
        $this->assertSame($discountValue, $discount->calculate($product));
    }

    public static function supportsProvider(): array
    {
        return [
            [10, 10, 'PLN', 'PLN', true],
            [9, 10, 'PLN', 'PLN', false],
            [10, 10, 'PLN', 'EUR', false],
        ];
    }
}
