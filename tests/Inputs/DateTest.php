<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, '', ['required' => true]],
            [true, '2018-06-21', []],
            [false, '2018-66-21', []],
            [false, '2018-06-21', ['max' => '2005-08-14']],
            [true, '2005-08-14', ['max' => '2005-08-14']],
            [true, '2001-06-21', ['max' => '2005-08-14']],
            [false, '2001-06-21', ['min' => '2005-08-14']],
            [true, '2011-06-21', ['min' => '2005-08-14']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Date();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Date();
        $this->assertSame('<input type="date">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="date" id="foo">',
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
                'This value is not a valid date.',
            ],
            [
                'foo',
                'Not valid date',
                ['date' => 'Not valid date']
            ],
            [
                '1999-01-01',
                'This value should be greater than or equal to "2000-01-01".'
            ],
            [
                '1999-01-01',
                'This value should be at least "2000-01-01"',
                ['min' => 'This value should be at least {{ compared_value }}']
            ],
            [
                '2002-01-01',
                'This value should be less than or equal to "2001-01-01".'
            ],
            [
                '2002-01-01',
                'This value cannot be greater than "2001-01-01"',
                ['max' => 'This value cannot be greater than {{ compared_value }}']
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Date(null, [
            'required' => true,
            'min' => '2000-01-01',
            'max' => '2001-01-01',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
