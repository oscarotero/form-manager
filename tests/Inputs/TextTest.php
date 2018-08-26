<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Text;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, 'hello', []],
            [true, '', []],
            [false, '', ['required' => true]],
            [false, '12345678901', ['maxlength' => 10]],
            [true, '', ['minlength' => 10]],
            [false, '', ['minlength' => 10, 'required' => true]],
            [false, 'abc', ['minlength' => 10]],
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
        $input = new Text();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
