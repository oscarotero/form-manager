<?php
declare(strict_types = 1);

namespace FormManager\Tests;

use FormManager\Nodes\InputText;
use FormManager\Nodes\Textarea;
use FormManager\Nodes\Button;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testInput()
    {
        $input = new InputText();

        $this->assertEquals('text', $input->getAttribute('type'));
        $this->assertEquals('<input type="text">', (string) $input);

        $input->name = 'foo';
        $input->value = 'Bar';
        $this->assertEquals('<input type="text" name="foo" value="Bar">', (string) $input);
    }

    public function typesProvider(): array
    {
        return [
            ['InputCheckbox', 'checkbox'],
            ['InputColor', 'color'],
            ['InputDate', 'date'],
            ['InputDatetimeLocal', 'datetime-local'],
            ['InputEmail', 'email'],
            ['InputFile', 'file'],
            ['InputHidden', 'hidden'],
            ['InputMonth', 'month'],
            ['InputNumber', 'number'],
            ['InputPassword', 'password'],
            ['InputRadio', 'radio'],
            ['InputRange', 'range'],
            ['InputSearch', 'search'],
            ['InputSubmit', 'submit'],
            ['InputTel', 'tel'],
            ['InputText', 'text'],
            ['InputTime', 'time'],
            ['InputUrl', 'url'],
            ['InputWeek', 'week'],
        ];
    }

    /**
     * @dataProvider typesProvider
     */
    public function testInputTypes(string $class, string $type)
    {
        $class = "FormManager\\Nodes\\{$class}";
        $input = new $class($type);
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

    public function testButton()
    {
        $button = new Button();

        $this->assertEquals('<button type="button"></button>', (string) $button);

        $button->name = 'foo';
        $button->value = 'Bar';
        $this->assertEquals('<button type="button" name="foo" value="Bar"></button>', (string) $button);

        $button = new Button('submit');
        $this->assertEquals('submit', $button->type);
    }
}
