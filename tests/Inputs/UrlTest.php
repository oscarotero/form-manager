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
}
