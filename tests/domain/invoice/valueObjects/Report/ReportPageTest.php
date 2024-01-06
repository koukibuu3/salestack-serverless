<?php

declare(strict_types=1);

namespace Tests\Domain\Invoice\ValueObjects\Report;

use PHPUnit\Framework\TestCase;
use App\Domain\Invoice\Entities\Sale;
use App\Domain\Invoice\ValueObjects\Report\ReportPage;
use InvalidArgumentException;

/**
 * @group domain
 * @group invoice
 * @group valueObjects
 * @group invoiceReportPage
 */
class ReportPageTest extends TestCase
{
    /**
     * デフォルトの売上配列
     */
    private readonly array $defaultRequestSaleParameter;

    public function setUp(): void
    {
        parent::setUp();

        $this->defaultRequestSaleParameter = [
            'orderDate' => '2024-01-06',
            'itemName' => 'item',
            'itemPrice' => 100,
            'quantity' => 1,
            'memo' => 'memo',
            'amount' => 100,
            'taxPrice' => 10,
        ];
    }

    /** @test */
    public function ページ番号が取得できる(): void
    {
        $page = new ReportPage(1, []);
        $this->assertSame(1, $page->pageNo);
    }

    /** @test */
    public function 売上が取得できる(): void
    {
        $sales = [
            new Sale(...$this->defaultRequestSaleParameter),
        ];

        $page = new ReportPage(1, $sales);
        $this->assertSame($sales, $page->sales);
    }

    /** @test */
    public function 売上件数が取得できる(): void
    {
        $sales = [
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
        ];

        $page = new ReportPage(1, $sales);
        $this->assertSame(2, $page->salesCount);
    }

    /** @test */
    public function 売上合計金額が取得できる(): void
    {
        $sales = [
            new Sale(...[...$this->defaultRequestSaleParameter, 'amount' => 100]),
            new Sale(...[...$this->defaultRequestSaleParameter, 'amount' => 300]),
        ];

        $page = new ReportPage(1, $sales);
        $this->assertSame(400, $page->salesAmount);
    }

    /** @test */
    public function 売上件数が10件を超える場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Sale rows must be less than or equal to 10');

        $sales = [
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter),
            new Sale(...$this->defaultRequestSaleParameter), // 11件目
        ];
        new ReportPage(1, $sales);
    }
}
