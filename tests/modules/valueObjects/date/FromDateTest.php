<?php

declare(strict_types=1);

namespace Tests\Modules\ValueObjects\Date;

use App\Modules\ValueObjects\Date\FromDate;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group modules
 * @group valueObjects
 * @group date
 */
final class FromDateTest extends TestCase
{
    private FromDate $fromDate;

    public function setUp(): void
    {
        parent::setUp();

        $this->fromDate = new FromDate('2023/08/27');
    }

    /** @test */
    public function 開始日時が取得できる(): void
    {
        $this->assertSame('2023-08-27', $this->fromDate->value);
    }

    /** @test */
    public function 開始日時が空の場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('fromDate is empty.');

        new FromDate('');
    }

    /** @test */
    public function 開始日時が不正な値の場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('fromDate is invalid.');

        new FromDate('2023/08/32');
    }
}
