<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Input;
use FormManager\Textarea;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testInput()
    {
        $input = new Input();

        $this->assertEquals('text', $input->getAttribute('type'));
        $this->assertEquals('<input type="text">', (string) $input);

        $input->name = 'foo';
        $input->value = 'Bar';
        $this->assertEquals('<input type="text" name="foo" value="Bar">', (string) $input);
    }

    public function typesProvider(): array
    {
        return [
            ['checkbox'],
            ['color'],
            ['date'],
            ['datetime-local'],
            ['email'],
            ['file'],
            ['hidden'],
            ['month'],
            ['number'],
            ['password'],
            ['radio'],
            ['range'],
            ['search'],
            ['submit'],
            ['tel'],
            ['text'],
            ['time'],
            ['url'],
            ['week'],
        ];
    }

    /**
     * @dataProvider typesProvider
     */
    public function testInputTypes(string $type)
    {
        $input = new Input($type);
        $this->assertEquals($type, $input->getAttribute('type'));
    }

    public function testTextarea()
    {
        $textarea = new Textarea();

        $this->assertEquals('<textarea></textarea>', (string) $textarea);

        $textarea->name = 'foo';
        $textarea->value = 'Bar';
        $this->assertEquals('<textarea name="foo">Bar</textarea>', (string) $textarea);
    }
}
