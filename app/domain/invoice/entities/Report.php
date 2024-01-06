<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Entities;

use App\Domain\Invoice\ValueObjects\Report\FileName;
use App\Domain\Invoice\ValueObjects\Report\ReportPageCollection;

/**
 * 請求書
 */
final class Report
{
    public function __construct(
        public readonly FileName $fileName,
        public readonly ReportPageCollection $pages,
    ) {
    }
}
