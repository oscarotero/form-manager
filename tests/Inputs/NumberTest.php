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
            [true, '', []],
            [false, '', ['required' => true]],
            [false, 'aaa', []],
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
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Number();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Number();
        $this->assertSame('<input type="number">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="number" id="foo">',
            (string) $input
        );
    }

    public function errorProvider()
    {
        return [
            [
                null,
                'This value should not be blank.',
            ],
            [
                null,
                'This is required!',
                ['required' => 'This is required!'],
            ],
            [
                'foo',
                'This value is not a valid number.',
            ],
            [
                'foo',
                'Not valid number',
                ['number' => 'Not valid number'],
            ],
            [
                0,
                'This value should be greater than or equal to 1.',
            ],
            [
                0,
                'This value should be at least 1',
                ['min' => 'This value should be at least {{ compared_value }}'],
            ],
            [
                11,
                'This value should be less than or equal to 10.',
            ],
            [
                11,
                'This value cannot be greater than 10',
                ['max' => 'This value cannot be greater than {{ compared_value }}'],
            ],
            [
                8,
                'This number is not valid.',
            ],
            [
                8,
                'Not valid number',
                ['step' => 'Not valid number'],
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Number(null, [
            'required' => true,
            'min' => 1,
            'max' => 10,
            'step' => 5,
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
