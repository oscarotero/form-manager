<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, '#333333', []],
            [false, '#333', []],
            [false, '333333', []],
            [true, '#33333f', []],
            [false, '#33333F', []],
            [false, '#33333h', []],
            [false, '', ['required' => true]],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Color();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
