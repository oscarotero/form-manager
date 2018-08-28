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
}
