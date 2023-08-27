<?php

declare(strict_types=1);

namespace App\Modules\ValueObjects;

use InvalidArgumentException;
use App\Modules\ValueObjects\Amount;
use App\Modules\ValueObjects\ItemName;
use App\Modules\ValueObjects\ItemPrice;
use App\Modules\ValueObjects\Memo;
use App\Modules\ValueObjects\Quantity;
use App\Modules\ValueObjects\TaxPrice;
use App\Modules\ValueObjects\Date\OrderDate;
use App\Modules\ValueObjects\Parameter\RequestParameter;

/**
 * 売上
 */
class Sale
{
    /** @var OrderDate 注文日時 */
    readonly public OrderDate $orderDate;

    /** @var ItemName 商品名 */
    readonly public ItemName $itemName;

    /** @var ItemPrice 商品価格 */
    readonly public ItemPrice $itemPrice;

    /** @var Quantity 数量 */
    readonly public Quantity $quantity;

    /** @var Memo 備考 */
    readonly public Memo $memo;

    /** @var Amount 金額 */
    readonly public Amount $amount;

    /** @var TaxPrice 税額 */
    readonly public TaxPrice $taxPrice;

    /**
     * @throws InvalidArgumentException 売上配列に必須のキーが存在しない場合
     */
    public function __construct(array $requestSale)
    {
        $requestParameter = new RequestParameter($requestSale);

        $this->orderDate = new OrderDate((string) $requestParameter->get('orderDate'));
        $this->itemName = new ItemName((string) $requestParameter->get('itemName'));
        $this->itemPrice = new ItemPrice((int) $requestParameter->get('itemPrice'));
        $this->quantity = new Quantity((float) $requestParameter->get('quantity'));
        $this->memo = new Memo((string) $requestParameter->get('memo'));
        $this->amount = new Amount((int) $requestParameter->get('amount'));
        $this->taxPrice = new TaxPrice((int) $requestParameter->get('taxPrice'));
    }
}
