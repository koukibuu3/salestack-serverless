<?php

declare(strict_types=1);

namespace Tests\Modules\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Modules\ValueObjects\Amount;
use App\Modules\ValueObjects\ItemName;
use App\Modules\ValueObjects\ItemPrice;
use App\Modules\ValueObjects\Memo;
use App\Modules\ValueObjects\Quantity;
use App\Modules\ValueObjects\Sale;
use App\Modules\ValueObjects\TaxPrice;
use App\Modules\ValueObjects\Date\OrderDate;
use InvalidArgumentException;

/**
 * @group modules
 * @group valueObjects
 */
final class SaleTest extends TestCase
{
    private Sale $reportSale;

    public function setUp(): void
    {
        parent::setUp();

        $this->reportSale = new Sale([
            'orderDate' => '2023-08-13',
            'itemName' => 'テスト商品',
            'itemPrice' => 1000,
            'quantity' => 10.5,
            'memo' => 'テストメモ',
            'amount' => 10500,
            'taxPrice' => 840,
        ]);
    }

    /** @test */
    public function 注文日時が取得できる(): void
    {
        $this->assertEquals(new OrderDate('2023-08-13'), $this->reportSale->orderDate);
    }

    /** @test */
    public function 商品名が取得できる(): void
    {
        $this->assertEquals(new ItemName('テスト商品'), $this->reportSale->itemName);
    }

    /** @test */
    public function 商品価格が取得できる(): void
    {
        $this->assertEquals(new ItemPrice(1000), $this->reportSale->itemPrice);
    }

    /** @test */
    public function 数量が取得できる(): void
    {
        $this->assertEquals(new Quantity(10.5), $this->reportSale->quantity);
    }

    /** @test */
    public function メモが取得できる(): void
    {
        $this->assertEquals(new Memo('テストメモ'), $this->reportSale->memo);
    }

    /** @test */
    public function 売上金額が取得できる(): void
    {
        $this->assertEquals(new Amount(10500), $this->reportSale->amount);
    }

    /** @test */
    public function 税込価格が取得できる(): void
    {
        $this->assertEquals(new TaxPrice(840), $this->reportSale->taxPrice);
    }

    /** @test */
    public function 必須パラメータが指定されていない場合は例外を投げる(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('orderDate is not exist.');

        new Sale([
            // 'orderDate' => '2023-08-13',
            'itemName' => 'テスト商品',
            'itemPrice' => '1000',
            'quantity' => '10.5',
            'memo' => 'テストメモ',
            'amount' => '10500',
            'taxPrice' => '840',
        ]);
    }
}
