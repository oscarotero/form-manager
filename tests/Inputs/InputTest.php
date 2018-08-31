<?php
declare(strict_types = 1);

namespace FormManager\Tests\Inputs;

use FormManager\Inputs\Text;
use FormManager\Inputs\Input;
use FormManager\Inputs\Textarea;
use FormManager\Inputs\Select;
use FormManager\Inputs\Submit;
use Symfony\Component\Validator\Constraints;
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
        $input->setAttributes(['required', 'readonly', 'id' => 'foo']);
        $this->assertEquals('<input type="text" name="foo" value="Bar" required readonly id="foo">', (string) $input);
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
        $input = new $class();
        $this->assertEquals($type, $input->getAttribute('type'));
    }

    public function testLabel()
    {
        Input::resetIdIndex();
        $input = new Text();
        $input->setLabel('Hello world', ['class' => 'is-error']);

        $this->assertEquals(
            '<label class="is-error" for="id-input-1">Hello world</label> <input type="text" id="id-input-1">',
            (string) $input
        );
        $this->assertEquals('<label class="is-error" for="id-input-1">Hello world</label>', (string) $input->label);
    }

    public function testLabelAndId()
    {
        Input::resetIdIndex();
        $input = new Text('Hello world');

        $this->assertEquals(
            '<label for="id-input-1">Hello world</label> <input type="text" id="id-input-1">',
            (string) $input
        );

        $input->id = 'foo';

        $this->assertEquals(
            '<label for="foo">Hello world</label> <input type="text" id="foo">',
            (string) $input
        );
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
        $select = new Select(null, [
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
        $button = new Submit('Send');

        $this->assertEquals('submit', $button->type);
        $this->assertEquals('<button type="submit">Send</button>', (string) $button);

        $button->name = 'foo';
        $button->value = 'Bar';
        $this->assertEquals('<button type="submit" name="foo" value="Bar">Send</button>', (string) $button);
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

        $input->setTemplate('{{ label }} <div>{{ input }}</div>');
        $this->assertSame(
            '<label for="foo">Click here</label> <div><input type="text" id="foo"></div>',
            (string) $input
        );

        $input->setTemplate('<div>{{ template }}</div>');
        $this->assertSame(
            '<div><label for="foo">Click here</label> <div><input type="text" id="foo"></div></div>',
            (string) $input
        );
    }

    public function testCustomConstraint()
    {
        $input = new Text();
        $input->addConstraint(new Constraints\Ip());

        $input->setValue('invalid-ip');
        $this->assertFalse($input->isValid());

        $error = $input->getError();
        $this->assertSame('This is not a valid IP address.', (string) $error);

        $input->setValue('10.34.29.109');
        $this->assertTrue($input->isValid());
    }

    public function testDatalist()
    {
        Input::resetIdIndex();

        $input = new Text();
        $datalist = $input->createDatalist([
            'One' => 'One',
            'Two' => 'Two',
        ]);

        $this->assertSame($datalist->id, $input->list);
        $this->assertSame(
            '<datalist id="id-datalist-1"><option value="One">One</option><option value="Two">Two</option></datalist>',
            (string) $datalist
        );
    }
}
