<?php

declare(strict_types=1);

namespace Tests\Application\Parameters;

use App\Application\Parameters\RequestParameter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group application
 * @group parameters
 * @group requestParameter
 */
final class RequestParameterTest extends TestCase
{
    private array $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = [
            'param1' => 'テストパラメータ1',
            'param2' => [
                'param2-1' => 'テストパラメータ2-1',
                'param2-2' => 'テストパラメータ2-2',
            ],
        ];
    }

    /** @test */
    public function リクエスト配列の指定したキーの値を取得できる(): void
    {
        $param = new RequestParameter($this->request);

        $this->assertEquals('テストパラメータ1', $param->get('param1'));
        $this->assertEquals([
            'param2-1' => 'テストパラメータ2-1',
            'param2-2' => 'テストパラメータ2-2',
        ], $param->get('param2'));
    }

    /** @test */
    public function リクエスト配列の指定したキーが存在しない場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('param3 is not exist.');

        $param = new RequestParameter($this->request);

        $param->get('param3');
    }
}
