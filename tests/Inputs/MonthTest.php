<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use Respect\Validation\Validator as v;
use FormManager\Inputs\Month;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            // [false, '2014-13', []],
            [true, '2014-09', []],
            [false, '2014-09', ['max' => '2014-08']],
            [true, '2014-09', ['max' => '2014-09']],
            [false, '2014-09', ['min' => '2014-10']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Month();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Month();
        $this->assertSame('<input type="month">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="month" id="foo">',
            (string) $input
        );
    }
}
