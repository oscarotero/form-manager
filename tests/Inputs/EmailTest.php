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
            [false, 'email@domain.com', ['maxlength' => 4]],
            [false, 'email@domain.com', ['minlength' => 20]],
            [true, 'email@domain.com', ['maxlength' => 20, 'minlength' => 4]],
            [false, 'email@domain.com', ['pattern' => '.*@google.com']],
            [true, 'email@google.com', ['pattern' => '.*@google.com']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     * @param mixed $value
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
                'This value is not a valid email address.',
            ],
            [
                'foo',
                'Not valid email',
                ['email' => 'Not valid email'],
            ],
            [
                'foo@bar.com',
                'This value is too short. It should have 15 characters or more.',
            ],
            [
                'foo@bar.com',
                'This value should have at least 15 characters',
                ['minlength' => 'This value should have at least {{ limit }} characters'],
            ],
            [
                'foooooooooooo@bar.com',
                'This value is too long. It should have 20 characters or less.',
            ],
            [
                'foooooooooooo@bar.com',
                'This value cannot have more than 20 characters',
                ['maxlength' => 'This value cannot have more than {{ limit }} characters'],
            ],
            [
                'fooooooo@bar.com',
                'This value is not valid.',
            ],
            [
                'fooooooo@bar.com',
                'The value must be a .gal domain',
                ['pattern' => 'The value must be a .gal domain'],
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     * @param mixed $value
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Email(null, [
            'required' => true,
            'minlength' => 15,
            'maxlength' => 20,
            'pattern' => '.*\.gal',
        ]);

        $error = $input
            ->setValue($value)
            ->setErrorMessages($errorMessages)
            ->getError();

        $this->assertSame($message, (string) $error);
    }
}
