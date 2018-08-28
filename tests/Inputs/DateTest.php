<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, '', ['required' => true]],
            [true, '2018-06-21', []],
            [false, '2018-66-21', []],
            [false, '2018-06-21', ['max' => '2005-08-14']],
            [true, '2005-08-14', ['max' => '2005-08-14']],
            [true, '2001-06-21', ['max' => '2005-08-14']],
            [false, '2001-06-21', ['min' => '2005-08-14']],
            [true, '2011-06-21', ['min' => '2005-08-14']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Date();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Date();
        $this->assertSame('<input type="date">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="date" id="foo">',
            (string) $input
        );
    }
}
