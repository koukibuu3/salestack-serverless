<?php

declare(strict_types=1);

namespace App\Modules\ValueObjects\Parameter;

use InvalidArgumentException;

/**
 * リクエストパラメータ
 */
final class RequestParameter
{
    /**
     * @param array $request リクエスト配列
     */
    public function __construct(private array $request)
    {
    }

    /**
     * リクエスト配列の指定したキーの値を取得
     *
     * @throws InvalidArgumentException 指定したキーが存在しない場合
     */
    public function get(string $key): mixed
    {
        if (!isset($this->request[$key])) {
            throw new InvalidArgumentException("$key is not exist.");
        }
        return $this->request[$key];
    }
}
