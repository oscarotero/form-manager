<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, '', ['required' => true]],
            [true, 0, ['required' => true]],
            [true, '8', []],
            [false, '8', ['min' => 9]],
            [true, '8', ['min' => 8]],
            [true, '8', ['max' => 8]],
            [false, '9', ['max' => 8]],
            [false, '9', ['step' => 4]],
            [true, '9', ['step' => 3]],
            [true, '9', ['step' => 3, 'min' => 0, 'max' => 9]],
            [false, '10', ['step' => 3, 'min' => 0, 'max' => 9]],
            [false, 8, ['step' => 3, 'min' => 0, 'max' => 9]],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Number();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
