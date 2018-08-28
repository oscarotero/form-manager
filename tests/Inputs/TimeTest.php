<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, '12:45', []],
            [false, '12:95', []],
            [true, '12:15', ['min' => '12:10']],
            [false, '12:15', ['min' => '12:20']],
            [false, '12:15', ['max' => '12:10']],
            [true, '12:15', ['max' => '12:20']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Time();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Time();
        $this->assertSame('<input type="time">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="time" id="foo">',
            (string) $input
        );
    }
}
