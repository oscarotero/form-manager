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

    public function testRender()
    {
        $input = new Color();
        $this->assertSame('<input type="color">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="color" id="foo">',
            (string) $input
        );
    }

    public function errorProvider()
    {
        return [
            [
                null,
                'This value should not be blank.'
            ],
            [
                null,
                'This is required!',
                ['required' => 'This is required!']
            ],
            [
                'foo',
                'This value is not a valid color.',
            ],
            [
                'foo',
                'Not valid color',
                ['color' => 'Not valid color']
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Color(null, [
            'required' => true,
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
