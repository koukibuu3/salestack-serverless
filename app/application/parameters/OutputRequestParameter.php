<?php

declare(strict_types=1);

namespace App\Application\Parameters;

use App\Application\Parameters\RequestParameter;
use App\Domain\Invoice\Entities\Sale;
use App\Domain\Invoice\ValueObjects\Report\CustomerName;
use App\Domain\Invoice\ValueObjects\Date\FromDate;
use App\Domain\Invoice\ValueObjects\Date\ToDate;
use InvalidArgumentException;

/**
 * 帳票出力のリクエストパラメータ
 */
final class OutputRequestParameter
{
    /** @var CustomerName 顧客名 */
    public readonly CustomerName $customerName;

    /** @var FromDate 開始日時 */
    public readonly FromDate $fromDate;

    /** @var ToDate 終了日時 */
    public readonly ToDate $toDate;

    /** @var Sale[] 売上配列 */
    public readonly array $sales;

    /**
     * @throws InvalidArgumentException リクエスト配列に必須のキーが存在しない場合
     */
    public function __construct(array $request)
    {
        $param = new RequestParameter($request);

        $this->customerName = new CustomerName($param->get('customerName'));
        $this->fromDate = new FromDate($param->get('fromDate'));
        $this->toDate = new ToDate($param->get('toDate'));

        $sales = $param->get('sales');
        if (!is_array($sales)) {
            throw new InvalidArgumentException('sales must be array.');
        }

        $this->sales = array_map(function (array $sale) {
            $saleParam = new RequestParameter($sale);
            return new Sale(
                $saleParam->get('orderDate'),
                $saleParam->get('itemName'),
                $saleParam->get('itemPrice'),
                $saleParam->get('quantity'),
                $saleParam->get('memo'),
                $saleParam->get('amount'),
                $saleParam->get('taxPrice'),
            );
        }, $sales);
    }
}
