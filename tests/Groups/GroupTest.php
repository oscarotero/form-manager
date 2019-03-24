<?php
declare(strict_types = 1);

namespace FormManager\Tests\Groups;

use FormManager\Inputs\Input;
use FormManager\Inputs\Text;
use FormManager\Groups\Group;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testGroup()
    {
        $input = new Group([
            'name' => new Text(),
            'surname' => new Text(),
        ]);

        $this->assertInstanceOf(Text::class, $input['name']);
        $this->assertInstanceOf(Text::class, $input['surname']);

        $this->assertSame('name', $input['name']->getAttribute('name'));
        $this->assertSame('surname', $input['surname']->getAttribute('name'));

        $input->setName('user');

        $this->assertSame('user[name]', $input['name']->getAttribute('name'));
        $this->assertSame('user[surname]', $input['surname']->getAttribute('name'));
    }

    public function testRender()
    {
        Input::resetIdIndex();

        $input = new Group([
            'name' => new Text(),
            'surname' => new Text(),
        ]);

        $this->assertSame(
            '<input type="text" name="name">'."\n".
            '<input type="text" name="surname">',
            (string) $input
        );
    }

    public function testClone()
    {
        $input = new Group([
            'name' => new Text(),
        ]);

        $input['name']->id = 'foo';

        $input2 = clone $input;
        $input2['name']->id = 'bar';

        $this->assertSame('foo', $input['name']->id);
        $this->assertSame('bar', $input2['name']->id);
    }

    public function testIterator()
    {
        $group = new Group([
            'name' => new Text(),
            'surname' => new Text(),
            'address' => new Text(),
        ]);

        $keys = [];

        foreach ($group as $name => $input) {
            $keys[] = $name;
        }

        $this->assertEquals(['name', 'surname', 'address'], $keys);
    }

    public function testInvalidInput()
    {
        $group = new Group();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The element "name" must implement FormManager\InputInterface');

        $group['name'] = new \StdClass();
    }
}
