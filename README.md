## Task:

Imagine you are implementing e-commerce system. You are required to write a discount calculator.
Calculator should accept list of available discounts as an constructor argument and expose public method applying discounts for a given list
of products and returning total value of the products.
Calculator must support the following types of discounts:

## Discount Rules

| Type | Rule | Example |
|------|------|---------|
| Fixed discount | `-X <currency>` | `-100 PLN` |
| Percentage discount | `-X%` | `-10%` |
| Volume discount | `-X <currency>` applied when at least **N** products are bought together | `-100 EUR` when at least **10** products are bought together |

Additionally discounts might be only applicable to specific products. You can assume that the product class has the following API:

```php
interface PriceInterface
{
    public function getAmount(): int;

    public function getCurrency(): string;
}
```

```php
interface PriceInterface
{
    public function getAmount(): int;

    public function getCurrency(): string;
}
```
