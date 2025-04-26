<?php
declare(strict_types=1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Week;
use PHPUnit\Framework\TestCase;

class WeekTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, '2014-W01', []],
            [true, '2014-W16', []],
            [true, '2014-W52', []],
            [false, '2014-W54', []],
            [false, '2014-W15', ['max' => '2014-W14']],
            [true, '2013-W15', ['max' => '2014-W14']],
            [true, '2014-W15', ['min' => '2014-W14']],
            [false, '2014-W15', ['min' => '2014-W16']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Week();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Week();
        $this->assertSame('<input type="week">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="week" id="foo">',
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
                'This value is not a valid week.',
            ],
            [
                'foo',
                'Not valid week',
                ['week' => 'Not valid week'],
            ],
            [
                '1999-W01',
                'This value should be greater than or equal to "2000-W01".',
            ],
            [
                '1999-W01',
                'This value should be at least "2000-W01"',
                ['min' => 'This value should be at least {{ compared_value }}'],
            ],
            [
                '2000-W11',
                'This value should be less than or equal to "2000-W09".',
            ],
            [
                '2000-W11',
                'This value cannot be greater than "2000-W09"',
                ['max' => 'This value cannot be greater than {{ compared_value }}'],
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Week(null, [
            'required' => true,
            'min' => '2000-W01',
            'max' => '2000-W09',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
