<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, '12:45', []],
            [false, '12:95', []],
            [true, '12:15', ['min' => '12:10']],
            [false, '12:15', ['min' => '12:20']],
            [false, '12:15', ['max' => '12:10']],
            [true, '12:15', ['max' => '12:20']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Time();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Time();
        $this->assertSame('<input type="time">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="time" id="foo">',
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
                'This value is not a valid time.',
            ],
            [
                'foo',
                'Not valid time',
                ['time' => 'Not valid time']
            ],
            [
                '11:00',
                'This value should be greater than or equal to "12:00".'
            ],
            [
                '11:00',
                'This value should be at least "12:00"',
                ['min' => 'This value should be at least {{ compared_value }}']
            ],
            [
                '15:00',
                'This value should be less than or equal to "14:59".'
            ],
            [
                '15:00',
                'This value cannot be greater than "14:59"',
                ['max' => 'This value cannot be greater than {{ compared_value }}']
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Time(null, [
            'required' => true,
            'min' => '12:00',
            'max' => '14:59',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
