<?php

declare(strict_types=1);

namespace Tests\Domain\Invoice\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Invoice\Entities\Report;
use App\Domain\Invoice\Entities\Sale;
use App\Domain\Invoice\Services\CreateReportService;
use App\Domain\Invoice\ValueObjects\Date\FromDate;
use App\Domain\Invoice\ValueObjects\Date\ToDate;
use App\Domain\Invoice\ValueObjects\OutputRequestParameter;
use App\Domain\Invoice\ValueObjects\Report\CustomerName;

/**
 * @group domain
 * @group invoice
 * @group services
 * @group createReportService
 */
class CreateReportServiceTest extends TestCase
{
    private CreateReportService $service;

    /** @test */
    public function 請求書の作成ができる(): void
    {
        $this->service = new CreateReportService(
            new CustomerName('顧客名'),
            new FromDate('2021-01-01'),
            new ToDate('2021-01-31'),
            [new Sale('2021-01-01 00:00:00', '商品名', 1000, 1, '備考', 1000, 100)],
        );

        $report = $this->service->run();

        $this->assertInstanceOf(Report::class, $report);
    }
}
