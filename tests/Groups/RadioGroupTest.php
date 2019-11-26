<?php
declare(strict_types = 1);

namespace FormManager\Tests\Groups;

use FormManager\Groups\RadioGroup;
use FormManager\Inputs\Input;
use FormManager\Inputs\Radio;
use PHPUnit\Framework\TestCase;

class RadioGroupTest extends TestCase
{
    public function testRadioGroup()
    {
        $input = new RadioGroup([
            1 => 'One',
            2 => 'Two',
        ]);

        $this->assertInstanceOf(Radio::class, $input[1]);
        $this->assertInstanceOf(Radio::class, $input[2]);

        $this->assertSame(1, $input[1]->getAttribute('value'));
        $this->assertSame(2, $input[2]->getAttribute('value'));

        $this->assertSame('', $input[1]->getAttribute('name'));
        $this->assertSame('', $input[2]->getAttribute('name'));

        $input->setName('foo');

        $this->assertSame('foo', $input[1]->getAttribute('name'));
        $this->assertSame('foo', $input[2]->getAttribute('name'));
    }

    public function testRender()
    {
        Input::resetIdIndex();

        $input = new RadioGroup([
            1 => 'One',
            2 => 'Two',
        ]);

        $this->assertSame(
            '<input type="radio" id="id-input-1" value="1" name=""> <label for="id-input-1">One</label>'."\n".
            '<input type="radio" id="id-input-2" value="2" name=""> <label for="id-input-2">Two</label>',
            (string) $input
        );
    }

    public function testClone()
    {
        $input = new RadioGroup([
            'name' => new Radio('One'),
        ]);

        $input['name']->id = 'foo';

        $input2 = clone $input;
        $input2['name']->id = 'bar';

        $this->assertSame('foo', $input['name']->id);
        $this->assertSame('bar', $input2['name']->id);
    }

    public function testIterator()
    {
        $group = new RadioGroup([
            'name' => new Radio(),
            'surname' => new Radio(),
            'address' => new Radio(),
        ]);

        $keys = [];

        foreach ($group as $name => $input) {
            $keys[] = $name;
        }

        $this->assertEquals(['name', 'surname', 'address'], $keys);
    }
}
