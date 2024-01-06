<?php

declare(strict_types=1);

namespace Tests\Application\Parameters;

use App\Application\Parameters\OutputRequestParameter;
use App\Domain\Invoice\Entities\Sale;
use App\Domain\Invoice\ValueObjects\Date\FromDate;
use App\Domain\Invoice\ValueObjects\Date\ToDate;
use App\Domain\Invoice\ValueObjects\Report\CustomerName;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group application
 * @group parameters
 * @group outputRequestParameter
 */
final class OutputRequestParameterTest extends TestCase
{
    private OutputRequestParameter $param;

    public function setUp(): void
    {
        parent::setUp();

        $this->param = new OutputRequestParameter([
            'customerName' => 'テスト顧客名',
            'fromDate' => '2023-08-27',
            'toDate' => '2023-09-02',
            'sales' => [[
                'orderDate' => '2023-08-29',
                'itemName' => 'テスト商品',
                'itemPrice' => 1000,
                'quantity' => 10.5,
                'memo' => 'テストメモ',
                'amount' => 10500,
                'taxPrice' => 840,
            ]],
        ]);
    }

    /** @test */
    public function 顧客名を取得できる(): void
    {
        $this->assertEquals(new CustomerName('テスト顧客名'), $this->param->customerName);
    }

    /** @test */
    public function 開始日時を取得できる(): void
    {
        $this->assertEquals(new FromDate('2023-08-27'), $this->param->fromDate);
    }

    /** @test */
    public function 終了日時を取得できる(): void
    {
        $this->assertEquals(new ToDate('2023-09-02'), $this->param->toDate);
    }

    /** @test */
    public function 売上配列を取得できる(): void
    {
        $this->assertEquals([
            new Sale(
                '2023-08-29',
                'テスト商品',
                1000,
                10.5,
                'テストメモ',
                10500,
                840,
            ),
        ], $this->param->sales);
    }

    /** @test */
    public function 必須パラメータが指定されていない場合は例外を投げる(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('customerName is not exist.');

        new OutputRequestParameter([
            // 'customerName' => 'テスト顧客名',
            'fromDate' => '2023-08-27',
            'toDate' => '2023-09-02',
            'sales' => [[
                'orderDate' => '2023-08-29',
                'itemName' => 'テスト商品',
                'itemPrice' => 1000,
                'quantity' => 10.5,
                'memo' => 'テストメモ',
                'amount' => 10500,
                'taxPrice' => 840,
            ]],
        ]);
    }
}
