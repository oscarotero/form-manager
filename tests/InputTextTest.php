<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Nodes\InputText;
use PHPUnit\Framework\TestCase;

class InputTextTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, 'hello', []],
            [true, '', []],
            [false, '', ['required' => true]],
            [false, '12345678901', ['maxlength' => 10]],
            [true, '12345678901', ['maxlength' => 20]],
            [false, 'hellow-', ['pattern' => '\w+']],
            [true, 'hellow', ['pattern' => '\w+']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new InputText();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
