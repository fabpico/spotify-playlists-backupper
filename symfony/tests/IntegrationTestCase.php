<?php declare(strict_types=1);

namespace App\Tests;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{

    public static function setUpBeforeClass(): void
    {
        static::bootKernel();
    }

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

}