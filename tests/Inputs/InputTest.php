<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Text;
use FormManager\Inputs\Textarea;
use FormManager\Inputs\Select;
use FormManager\Inputs\Submit;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function testInput()
    {
        $input = new Text();

        $this->assertEquals('text', $input->getAttribute('type'));
        $this->assertEquals('<input type="text">', (string) $input);

        $input->name = 'foo';
        $input->value = 'Bar';
        $this->assertEquals('<input type="text" name="foo" value="Bar">', (string) $input);
    }

    public function typesProvider(): array
    {
        return [
            ['Checkbox', 'checkbox'],
            ['Color', 'color'],
            ['Date', 'date'],
            ['DatetimeLocal', 'datetime-local'],
            ['Email', 'email'],
            ['File', 'file'],
            ['Hidden', 'hidden'],
            ['Month', 'month'],
            ['Number', 'number'],
            ['Password', 'password'],
            ['Radio', 'radio'],
            ['Range', 'range'],
            ['Search', 'search'],
            ['Submit', 'submit'],
            ['Tel', 'tel'],
            ['Text', 'text'],
            ['Time', 'time'],
            ['Url', 'url'],
            ['Week', 'week'],
        ];
    }

    /**
     * @dataProvider typesProvider
     */
    public function testInputTypes(string $class, string $type)
    {
        $class = "FormManager\\Inputs\\{$class}";
        $input = new $class($type);
        $this->assertEquals($type, $input->getAttribute('type'));
    }

    public function testLabel()
    {
        $input = new Text();
        $input->setLabel('Hello world', ['class' => 'is-error']);

        $this->assertEquals('<input type="text" id="id-input-1">', (string) $input);
        $this->assertEquals('<label class="is-error" for="id-input-1">Hello world</label>', (string) $input->label);
    }

    public function testTextarea()
    {
        $textarea = new Textarea();

        $this->assertEquals('<textarea></textarea>', (string) $textarea);

        $textarea->name = 'foo';
        $textarea->value = 'Bar';
        $this->assertEquals('<textarea name="foo">Bar</textarea>', (string) $textarea);
    }

    public function testSelect()
    {
        $select = new Select([
            1 => 'One',
            2 => 'Two',
        ]);

        $this->assertEquals('<select><option value="1">One</option><option value="2">Two</option></select>', (string) $select);

        $select->name = 'foo';
        $select->value = 2;

        $this->assertEquals('<select name="foo"><option value="1">One</option><option value="2" selected>Two</option></select>', (string) $select);
    }

    public function testSubmit()
    {
        $button = new Submit();

        $this->assertEquals('submit', $button->type);
        $this->assertEquals('<button type="submit"></button>', (string) $button);

        $button->name = 'foo';
        $button->value = 'Bar';
        $this->assertEquals('<button type="submit" name="foo" value="Bar"></button>', (string) $button);
    }
}
