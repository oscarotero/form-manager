<?php
declare(strict_types = 1);

namespace FormManager\Tests\Groups;

use FormManager\Inputs\Input;
use FormManager\Inputs\Submit;
use FormManager\Groups\SubmitGroup;
use PHPUnit\Framework\TestCase;

class SubmitGroupTest extends TestCase
{
    public function testSubmitGroup()
    {
        $input = new SubmitGroup([
            1 => 'One',
            2 => 'Two',
        ]);

        $this->assertInstanceOf(Submit::class, $input[1]);
        $this->assertInstanceOf(Submit::class, $input[2]);

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

        $submit = new SubmitGroup([
            1 => 'One',
            2 => 'Two',
        ]);
        $submit->setName('action');

        $this->assertSame(
            '<button type="submit" value="1" name="action">One</button>'."\n".
            '<button type="submit" value="2" name="action">Two</button>',
            (string) $submit
        );
    }

    public function testClone()
    {
        $submit = new SubmitGroup([
            'name' => new Submit('One'),
        ]);

        $submit['name']->id = 'foo';

        $submit2 = clone $submit;
        $submit2['name']->id = 'bar';

        $this->assertSame('foo', $submit['name']->id);
        $this->assertSame('bar', $submit2['name']->id);
    }

    public function testIterator()
    {
        $group = new SubmitGroup([
            'name' => new Submit(),
            'surname' => new Submit(),
            'address' => new Submit(),
        ]);

        $keys = [];

        foreach ($group as $name => $submit) {
            $keys[] = $name;
        }

        $this->assertEquals(['name', 'surname', 'address'], $keys);
    }
}
