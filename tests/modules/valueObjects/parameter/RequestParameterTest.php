<?php

declare(strict_types=1);

namespace Tests\Modules\ValueObjects\Parameter;

use App\Modules\ValueObjects\Parameter\RequestParameter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group modules
 * @group valueObjects
 * @group parameter
 */
final class RequestParameterTest extends TestCase
{
    private RequestParameter $requestParameter;

    public function setUp(): void
    {
        parent::setUp();

        $this->requestParameter = new RequestParameter([
            'stringValue' => 'value',
            'intValue' => 1,
            'floatValue' => 1.1,
            'booleanValue' => true,
            'arrayValue' => ['value1', 'value2'],
        ]);
    }

    /** @test */
    public function 指定したキーの値を取得できる(): void
    {
        $this->assertSame('value', $this->requestParameter->get('stringValue'));
        $this->assertSame(1, $this->requestParameter->get('intValue'));
        $this->assertSame(1.1, $this->requestParameter->get('floatValue'));
        $this->assertTrue($this->requestParameter->get('booleanValue'));
        $this->assertSame(['value1', 'value2'], $this->requestParameter->get('arrayValue'));
    }

    /** @test */
    public function 指定したキーが存在しない場合は例外が発生する(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('notExistKey is not exist.');

        $this->requestParameter->get('notExistKey');
    }
}
