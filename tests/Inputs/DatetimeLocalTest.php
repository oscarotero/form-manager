<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\DatetimeLocal;
use PHPUnit\Framework\TestCase;

class DatetimeLocalTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, '2005-33-14T15:52:01', []],
            [true, '2005-08-14T15:52:01', []],
            [false, '2005-08-14T15:52:01', ['max' => '2004-08-14T15:52:01']],
            [false, '2005-08-14T15:52:01', ['min' => '2006-08-14T15:52:01']],
            [true, '2006-08-14T15:52:01', ['min' => '2006-08-14T15:52:01']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new DatetimeLocal();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
