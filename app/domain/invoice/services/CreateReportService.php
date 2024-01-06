<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Services;

use App\Domain\Invoice\Entities\Report;
use App\Domain\Invoice\ValueObjects\Date\FromDate;
use App\Domain\Invoice\ValueObjects\Date\ToDate;
use App\Domain\Invoice\ValueObjects\Report\ReportPage;
use App\Domain\Invoice\ValueObjects\Report\ReportPageCollection;
use App\Domain\Invoice\ValueObjects\Report\FileName;
use App\Domain\Invoice\ValueObjects\Report\CustomerName;

/**
 * 請求書作成サービス
 */
final class CreateReportService
{
    public function __construct(
        private readonly CustomerName $customerName,
        private readonly FromDate $fromDate,
        private readonly ToDate $toDate,
        private readonly array $sales,
    ) {
    }

    public function run(): Report
    {
        $fileName = $this->createFileName();
        $pages = $this->createPages();

        return new Report($fileName, $pages);
    }

    private function createFileName(): FileName
    {
        $customerName = $this->customerName->value;
        $fromDate = $this->fromDate->value;
        $toDate = $this->toDate->value;

        return new FileName("請求書_{$customerName}_{$fromDate}~{$toDate}.xlsx");
    }

    private function createPages(): ReportPageCollection
    {
        $sales = $this->sales;

        $pages = [];
        for ($pageNo = 1; $pageNo < count($sales) / ReportPage::MAX_ROWS; $pageNo++) {
            $offset = ($pageNo - 1) * ReportPage::MAX_ROWS;
            $slicedSales = array_slice($sales, $offset, ReportPage::MAX_ROWS);
            $pages[] = new ReportPage($pageNo, $slicedSales);
        }

        return new ReportPageCollection($pages);
    }
}
