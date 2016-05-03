<?php

use FormManager\Builder;
use FormManager\Fields\Group;

class GroupTest extends BaseTest
{
    public function testBase()
    {
        $field = Builder::group([
            'name' => Builder::text()->label('Name'),
            'email' => Builder::email()->label('email'),
            'age' => Builder::number()->label('Age'),
            'image' => Builder::file()->label('Image'),
        ]);

        $this->assertInstanceOf('FormManager\\Fields\\Group', $field);
        $this->assertInstanceOf('FormManager\\Fields\\Text', $field['name']);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(Group $field)
    {
        $field->val([
            'name' => 'Oscar',
            'email' => 'oscar@email.com',
            'age' => '35',
            'image' => [
                'name' => '1.png',
                'type' => 'image/png',
                'tmp_name' => '/tmp/phpTobJ71',
                'error' => 0,
                'size' => 2297,
            ],
        ]);

        $this->assertCount(4, $field->val());
        $this->assertEquals('Oscar', $field['name']->val());
    }
}
