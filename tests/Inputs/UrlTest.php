<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, null, []],
            [true, 'http://example.com', []],
            [true, '', []],
            [false, 'http://m.co', ['minlength' => 20]],
            [true, 'http://m.co', ['minlength' => 10]],
            [false, 'http://example.com', ['maxlength' => 10]],
            [true, 'http://example.com', ['maxlength' => 20]],
            [false, 'http://example.com', ['pattern' => '.*\.gal']],
            [true, 'http://example.gal', ['pattern' => '.*\.gal']],
        ];
    }

    /**
     * @dataProvider valuesProvider
     */
    public function testInput(bool $isValid, $value, array $attributes)
    {
        $input = new Url();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }

    public function testRender()
    {
        $input = new Url();
        $this->assertSame('<input type="url">', (string) $input);

        $input->id = 'foo';
        $input->setLabel('Click here');

        $this->assertSame(
            '<label for="foo">Click here</label> <input type="url" id="foo">',
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
                'This value is not a valid URL.',
            ],
            [
                'foo',
                'Not valid url',
                ['url' => 'Not valid url']
            ],
            [
                'http://a.co',
                'This value is too short. It should have 15 characters or more.'
            ],
            [
                'http://a.co',
                'This value should have at least 15 characters',
                ['minlength' => 'This value should have at least {{ limit }} characters']
            ],
            [
                'http://aaaaaaaaaaa.com',
                'This value is too long. It should have 20 characters or less.'
            ],
            [
                'http://aaaaaaaaaaa.com',
                'This value cannot have more than 20 characters',
                ['maxlength' => 'This value cannot have more than {{ limit }} characters']
            ],
            [
                'http://aaaaaaa.com',
                'This value is not valid.',
            ],
            [
                'http://aaaaaaa.com',
                'The value must be a .gal domain',
                ['pattern' => 'The value must be a .gal domain']
            ],
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message, array $errorMessages = [])
    {
        $input = new Url(null, [
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
