<?php
use FormManager\Fields\Field;
use FormManager\Fields\Group;

class GroupTest extends BaseTest
{
    public function testBase()
    {
        $field = Field::group([
            'name' => Field::text()->label('Name'),
            'email' => Field::email()->label('email'),
            'age' => Field::number()->label('Age'),
            'image' => Field::file()->label('Image'),
        ]);

        $this->assertInstanceOf('FormManager\\Fields\\Group', $field);
        $this->assertInstanceOf('FormManager\\Fields\\Field', $field['name']);
        $this->assertInstanceOf('FormManager\\Label', $field->label);

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
