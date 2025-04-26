<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Month;
use PHPUnit\Framework\TestCase;

class MonthTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            // [false, '2014-13', []],
            [true, '2014-09', []],
            [false, '2014-09', ['max' => '2014-08']],
            [true, '2014-09', ['max' => '2014-09']],
            [false, '2014-09', ['min' => '2014-10']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Month();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Month();
        $this->assertSame('<input type="month">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="month" id="foo">',
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
                'This value is not a valid month.',
            ],
            [
                'foo',
                'Not valid month',
                ['month' => 'Not valid month'],
            ],
            [
                '1999-01',
                'This value should be greater than or equal to "2000-01".',
            ],
            [
                '1999-01',
                'This value should be at least "2000-01"',
                ['min' => 'This value should be at least {{ compared_value }}'],
            ],
            [
                '2002-01',
                'This value should be less than or equal to "2001-01".',
            ],
            [
                '2002-01',
                'This value cannot be greater than "2001-01"',
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
        $input = new Month(null, [
            'required' => true,
            'min' => '2000-01',
            'max' => '2001-01',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
