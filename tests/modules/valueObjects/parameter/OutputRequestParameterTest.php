<?php

declare(strict_types=1);

namespace Tests\Modules\ValueObjects\Parameter;

use App\Modules\ValueObjects\CustomerName;
use App\Modules\ValueObjects\Date\FromDate;
use App\Modules\ValueObjects\Date\ToDate;
use App\Modules\ValueObjects\Parameter\OutputRequestParameter;
use App\Modules\ValueObjects\Sale;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group modules
 * @group valueObjects
 * @group parameter
 */
final class OutputRequestParameterTest extends TestCase
{
    private OutputRequestParameter $outputRequestParameter;

    public function setUp(): void
    {
        parent::setUp();

        $this->outputRequestParameter = new OutputRequestParameter([
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
        $this->assertEquals(new CustomerName('テスト顧客名'), $this->outputRequestParameter->customerName);
    }

    /** @test */
    public function 開始日時を取得できる(): void
    {
        $this->assertEquals(new FromDate('2023-08-27'), $this->outputRequestParameter->fromDate);
    }

    /** @test */
    public function 終了日時を取得できる(): void
    {
        $this->assertEquals(new ToDate('2023-09-02'), $this->outputRequestParameter->toDate);
    }

    /** @test */
    public function 売上配列を取得できる(): void
    {
        $this->assertEquals([
            new Sale([
                'orderDate' => '2023-08-29',
                'itemName' => 'テスト商品',
                'itemPrice' => 1000,
                'quantity' => 10.5,
                'memo' => 'テストメモ',
                'amount' => 10500,
                'taxPrice' => 840,
            ]),
        ], $this->outputRequestParameter->sales);
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
