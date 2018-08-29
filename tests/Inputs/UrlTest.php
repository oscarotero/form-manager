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
            [null, 'web must not be optional']
        ];
    }

    /**
     * @dataProvider errorProvider
     */
    public function testErrors($value, string $message)
    {
        $input = new Url(null, ['required' => true, 'name' => 'web']);

        $error = $input->setValue($value)->getError();

        $this->assertSame($message, (string) $error);
    }
}
