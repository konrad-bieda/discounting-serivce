<?php

namespace App\Tests\integration\Factory;

use App\Domain\Discount\FixedDiscount;
use App\Domain\Discount\PercentageDiscount;
use App\Domain\Discount\VolumeDiscount;
use App\Factory\DiscountingServiceFactory;
use App\Service\DiscountingService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscountingServiceFactoryTest extends KernelTestCase
{
    public function testCreate(): void
    {
        self::bootKernel();

        $factory = static::getContainer()->get(DiscountingServiceFactory::class);
        $service = $factory->create(
            new FixedDiscount(10, 'PLN', ['code1']),
            new PercentageDiscount(10),
            new VolumeDiscount(10, 'PLN', 1)
        );

        $this->assertInstanceOf(DiscountingService::class, $service);
    }
}
