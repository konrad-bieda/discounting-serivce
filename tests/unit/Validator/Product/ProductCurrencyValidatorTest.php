<?php

namespace App\Tests\unit\Validator\Product;

use App\Domain\ValueObject\Price;
use App\Domain\Product\Product;
use App\DTO\ProductCollectionDTO;
use App\Validator\Product\ProductsCurrencyValidator;
use DomainException;
use PHPUnit\Framework\TestCase;

class ProductCurrencyValidatorTest extends TestCase
{
    public function testValidateShouldNotThrowExceptionForSameCurrencies(): void
    {
        // Arrange
        $products = new ProductCollectionDTO(
            ...[
                new Product('code1', new Price(20, 'PLN'), 15),
                new Product('code2', new Price(100, 'PLN'), 5),
                new Product('code3', new Price(50, 'PLN'), 1)
            ]
        );

        $validator = new ProductsCurrencyValidator();

        // Act & Assert
        $this->expectNotToPerformAssertions();
        $validator->validate($products);
    }

    public function testValidateShouldThrowExceptionForDifferentCurrencies(): void
    {
        // Arrange
        $products = new ProductCollectionDTO(
            ...[
                new Product('code1', new Price(20, 'EUR'), 15),
                new Product('code2', new Price(100, 'PLN'), 5),
                new Product('code3', new Price(50, 'PLN'), 1)
            ]
        );

        $validator = new ProductsCurrencyValidator();

        // Act & Assert
        $this->expectException(DomainException::class);
        $validator->validate($products);
    }
}
