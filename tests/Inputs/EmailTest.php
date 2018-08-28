<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, null, ['required' => true]],
            [true, 'email@domain.com', []],
            [false, 'email@domain', []],
            [false, 'email@domain', ['maxlength' => 4]],
            [false, 'email@domain.com', ['pattern' => '.*@google.com']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Email();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Email();
        $this->assertSame('<input type="email">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="email" id="foo">',
            (string) $input
        );
    }
}
