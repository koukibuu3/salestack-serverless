<?php

declare(strict_types=1);

namespace Tests\Modules\ValueObjects;

use App\Modules\ValueObjects\CustomerName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group modules
 * @group valueObjects
 */
final class CustomerNameTest extends TestCase
{
    private CustomerName $customerName;

    public function setUp(): void
    {
        parent::setUp();

        $this->customerName = new CustomerName('顧客名');
    }

    /** @test */
    public function 顧客名を取得できる(): void
    {
        $this->assertSame('顧客名', $this->customerName->value);
    }

    /** @test */
    public function 顧客名が空の場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('customerName is empty.');

        new CustomerName('');
    }

    /** @test */
    public function 顧客名が20文字を超える場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('customerName length id expected 20, but 21.');

        new CustomerName('123456789012345678901');
    }
}
