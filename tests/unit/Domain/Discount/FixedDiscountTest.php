<?php

namespace App\Tests\unit\Domain\Discount;

use App\Domain\ValueObject\Price;
use App\Domain\Discount\FixedDiscount;
use App\Domain\Product\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FixedDiscountTest extends TestCase
{
    #[DataProvider('supportsProvider')]
    public function testSupports(string $productCode, array $discountCodes, string $productCurrency, string $discountCurrency, bool $expected): void
    {
        // Arrange
        $product = new Product($productCode, new Price(100, $productCurrency), 1);
        $discount = new FixedDiscount(1, $discountCurrency, $discountCodes);

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
        $discount = new FixedDiscount($discountValue, $currency, [$code]);

        // Act & Assert
        $this->assertSame($discountValue, $discount->calculate($product));
    }

    public static function supportsProvider(): array
    {
        return [
            ['code', ['code'], 'PLN', 'PLN', true],
            ['code', ['other_code'], 'PLN', 'PLN', false],
            ['code', ['other_code'], 'PLN', 'EUR', false],
            ['code', ['code'], 'PLN', 'EUR', false],
        ];
    }
}
