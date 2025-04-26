<?php
declare(strict_types=1);

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
     * @param mixed $value
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Text();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Text();
        $this->assertSame('<input type="text">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="text" id="foo">',
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
                'foobar',
                'This value is too short. It should have 15 characters or more.',
            ],
            [
                'foobar',
                'This value should have at least 15 characters',
                ['minlength' => 'This value should have at least {{ limit }} characters'],
            ],
            [
                'fooooooooooooooooobar',
                'This value is too long. It should have 20 characters or less.',
            ],
            [
                'fooooooooooooooooobar',
                'This value cannot have more than 20 characters',
                ['maxlength' => 'This value cannot have more than {{ limit }} characters'],
            ],
            [
                'fooooooooooobar',
                'This value is not valid.',
            ],
            [
                'fooooooooooobar',
                'The value must end with "baz"',
                ['pattern' => 'The value must end with "baz"'],
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Text(null, [
            'required' => true,
            'minlength' => 15,
            'maxlength' => 20,
            'pattern' => '.*baz',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
