<?php

namespace App\Validator\Product;

use App\DTO\ProductCollectionDTO;
use DomainException;

interface ProductsValidatorInterface
{
    /**
     * @throws DomainException
     */
    public function validate(ProductCollectionDTO $productCollectionDTO): void;
}
