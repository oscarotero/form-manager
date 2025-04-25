<?php
declare(strict_types = 1);

namespace FormManager\Tests\Groups;

use FormManager\Groups\Group;
use FormManager\Groups\MultipleGroupCollection;
use FormManager\Inputs\Hidden;
use FormManager\Inputs\Text;
use PHPUnit\Framework\TestCase;

class MultipleGroupCollectionTest extends TestCase
{
    public function testMultipleCollectionGroup()
    {
        $group1 = new Group([
            'type' => new Hidden(),
            'name' => new Text(),
            'surname' => new Text(),
        ]);

        $group2 = new Group([
            'type' => new Hidden(),
            'address1' => new Text(),
            'address2' => new Text(),
        ]);

        $input = new MultipleGroupCollection(compact('group1', 'group2'));

        $this->assertSame($group1, $input->getGroups()['group1']);
        $this->assertSame($group2, $input->getGroups()['group2']);
        $this->assertCount(0, $input);

        $input->setValue([
            [
                'type' => 'group1',
                'name' => 'Foo',
                'surname' => 'Bar',
            ],
        ]);

        $this->assertCount(1, $input);

        $this->assertInstanceOf(Group::class, $input[0]);
        $this->assertInstanceOf(Hidden::class, $input[0]['type']);
        $this->assertInstanceOf(Text::class, $input[0]['name']);
        $this->assertInstanceOf(Text::class, $input[0]['surname']);

        $this->assertSame('[0][type]', $input[0]['type']->getAttribute('name'));
        $this->assertSame('[0][name]', $input[0]['name']->getAttribute('name'));
        $this->assertSame('[0][surname]', $input[0]['surname']->getAttribute('name'));

        $input->setName('user');

        $this->assertSame('user[0][type]', $input[0]['type']->getAttribute('name'));
        $this->assertSame('user[0][name]', $input[0]['name']->getAttribute('name'));
        $this->assertSame('user[0][surname]', $input[0]['surname']->getAttribute('name'));
    }

    public function testClone()
    {
        $input = new MultipleGroupCollection([
            'group' => new Group([
                'name' => new Text(),
            ]),
        ]);

        $input->setValue([
            ['type' => 'group', 'name' => ''],
        ]);

        $input[0]['name']->id = 'foo';

        $input2 = clone $input;
        $input2[0]['name']->id = 'bar';

        $this->assertSame('foo', $input[0]['name']->id);
        $this->assertSame('bar', $input2[0]['name']->id);
    }

    public function testIterator()
    {
        $input = new MultipleGroupCollection([
            'group' => new Group([
                'name' => new Text(),
            ]),
        ]);

        $input->setValue([
            ['type' => 'group', 'name' => 'Oscar'],
            ['type' => 'group', 'name' => 'Laura'],
        ]);

        $keys = [];

        foreach ($input as $index => $group) {
            $keys[] = $index;
        }

        $this->assertEquals([0, 1], $keys);
    }
}
