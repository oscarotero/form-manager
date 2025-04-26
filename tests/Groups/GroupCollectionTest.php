<?php
declare(strict_types = 1);

namespace FormManager\Tests\Groups;

use FormManager\Groups\Group;
use FormManager\Groups\GroupCollection;
use FormManager\Inputs\Text;
use PHPUnit\Framework\TestCase;

class GroupCollectionTest extends TestCase
{
    public function testCollectionGroup()
    {
        $group = new Group([
            'name' => new Text(),
            'surname' => new Text(),
        ]);

        $input = new GroupCollection($group);

        $this->assertSame($group, $input->getGroup());
        $this->assertCount(0, $input);

        $input->setValue([
            [
                'name' => 'Foo',
                'surname' => 'Bar',
            ],
        ]);

        $this->assertCount(1, $input);

        $this->assertInstanceOf(Group::class, $input[0]);
        $this->assertInstanceOf(Text::class, $input[0]['name']);
        $this->assertInstanceOf(Text::class, $input[0]['surname']);

        $this->assertSame('[0][name]', $input[0]['name']->getAttribute('name'));
        $this->assertSame('[0][surname]', $input[0]['surname']->getAttribute('name'));

        $input->setName('user');

        $this->assertSame('user[0][name]', $input[0]['name']->getAttribute('name'));
        $this->assertSame('user[0][surname]', $input[0]['surname']->getAttribute('name'));
    }

    public function testClone()
    {
        $input = new GroupCollection(
            new Group([
                'name' => new Text(),
            ])
        );

        $input->setValue([
            ['name' => ''],
        ]);

        $input[0]['name']->id = 'foo';

        $input2 = clone $input;
        $input2[0]['name']->id = 'bar';

        $this->assertSame('foo', $input[0]['name']->id);
        $this->assertSame('bar', $input2[0]['name']->id);
    }

    public function testIterator()
    {
        $input = new GroupCollection(
            new Group([
                'name' => new Text(),
            ])
        );

        $input->setValue([
            ['name' => 'Oscar'],
            ['name' => 'Laura'],
        ]);

        $keys = [];

        foreach ($input as $index => $group) {
            $keys[] = $index;
        }

        $this->assertEquals([0, 1], $keys);
    }
}
