<?php

declare(strict_types=1);

namespace App\Modules\ValueObjects\Parameter;

use App\Modules\ValueObjects\CustomerName;
use App\Modules\ValueObjects\Date\FromDate;
use App\Modules\ValueObjects\Date\ToDate;
use App\Modules\ValueObjects\Parameter\RequestParameter;
use App\Modules\ValueObjects\Sale;
use InvalidArgumentException;

/**
 * 帳票出力のリクエストパラメータ
 */
final class OutputRequestParameter
{
    /** @var CustomerName 顧客名 */
    readonly public CustomerName $customerName;

    /** @var FromDate 開始日時 */
    readonly public FromDate $fromDate;

    /** @var ToDate 終了日時 */
    readonly public ToDate $toDate;

    /** @var Sale[] 売上配列 */
    readonly public array $sales;

    /**
     * @throws InvalidArgumentException リクエスト配列に必須のキーが存在しない場合
     */
    public function __construct(array $request)
    {
        $requestParameter = new RequestParameter($request);

        $this->customerName = new CustomerName($requestParameter->get('customerName'));
        $this->fromDate = new FromDate($requestParameter->get('fromDate'));
        $this->toDate = new ToDate($requestParameter->get('toDate'));

        $requestSales = $requestParameter->get('sales');
        if (!is_array($requestSales)) {
            throw new InvalidArgumentException('sales must be array.');
        }
        $this->sales = array_map(fn (array $requestSale) => new Sale($requestSale), $requestSales);
    }
}
