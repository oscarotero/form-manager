<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Week;
use PHPUnit\Framework\TestCase;

class WeekTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, '2014-W01', []],
            [true, '2014-W16', []],
            [true, '2014-W52', []],
            [false, '2014-W54', []],
            [false, '2014-W15', ['max' => '2014-W14']],
            [true, '2013-W15', ['max' => '2014-W14']],
            [true, '2014-W15', ['min' => '2014-W14']],
            [false, '2014-W15', ['min' => '2014-W16']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Week();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Week();
        $this->assertSame('<input type="week">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="week" id="foo">',
            (string) $input
        );
    }
}
