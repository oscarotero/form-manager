<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Textarea;
use PHPUnit\Framework\TestCase;

class TextareaTest extends TestCase
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
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Textarea();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Textarea();
        $this->assertSame('<textarea></textarea>', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <textarea id="foo"></textarea>',
            (string) $input
        );
    }
}
