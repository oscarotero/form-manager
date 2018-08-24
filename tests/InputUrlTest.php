<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Nodes\InputUrl;
use PHPUnit\Framework\TestCase;

class InputUrlTest extends TestCase
{
    public function valuesProvider(): array
    {
        return [
            [true, 'http://example.com', []],
            [true, '', []],
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
        $input = new InputUrl();
        $input->setAttributes($attributes);
        $input->value = $value;

        $this->assertSame($isValid, $input->isValid());
    }
}
