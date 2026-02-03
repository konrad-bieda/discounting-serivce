<?php

namespace App\Tests\Service;

use App\Service\DiscountingService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscountingServiceTest extends KernelTestCase
{
    public function testApplyDiscounts(): void
    {
//        self::bootKernel();

        $service = new DiscountingService();
        $result = $service->applyDiscount();

        $this->assertSame(1, $result);
    }
}
