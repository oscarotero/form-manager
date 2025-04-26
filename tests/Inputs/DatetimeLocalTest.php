<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\DatetimeLocal;
use PHPUnit\Framework\TestCase;

class DatetimeLocalTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [false, '2005-33-14T15:52:01', []],
            [true, '2005-08-14T15:52:01', []],
            [false, '2005-08-14T15:52:01', ['max' => '2004-08-14T15:52:01']],
            [false, '2005-08-14T15:52:01', ['min' => '2006-08-14T15:52:01']],
            [true, '2006-08-14T15:52:01', ['min' => '2006-08-14T15:52:01']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new DatetimeLocal();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new DatetimeLocal();
        $this->assertSame('<input type="datetime-local">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="datetime-local" id="foo">',
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
                'This value is not a valid datetime.',
            ],
            [
                'foo',
                'Not valid datetime',
                ['datetime-local' => 'Not valid datetime'],
            ],
            [
                '1999-01-01T10:10:10',
                'This value should be greater than or equal to "2000-01-01".',
            ],
            [
                '1999-01-01T10:10:10',
                'This value should be at least "2000-01-01"',
                ['min' => 'This value should be at least {{ compared_value }}'],
            ],
            [
                '2002-01-01T10:10:10',
                'This value should be less than or equal to "2001-01-01".',
            ],
            [
                '2002-01-01T10:10:10',
                'This value cannot be greater than "2001-01-01"',
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
        $input = new DatetimeLocal(null, [
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
