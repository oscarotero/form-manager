<?php
use FormManager\Fields\Field;
use FormManager\Fields\Collection;

class CollectionTest extends BaseTest
{
    public function testBase()
    {
        $field = Field::collection([
            'name' => Field::text()->label('Name'),
            'email' => Field::email()->label('email'),
            'age' => Field::number()->label('Age'),
            'image' => Field::file()->label('Image'),
        ]);

        $this->assertInstanceOf('FormManager\\Fields\\Collection', $field);
        $this->assertInstanceOf('FormManager\\Fields\\Group', $field->field);
        $this->assertInstanceOf('FormManager\\Label', $field->label);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(Collection $field)
    {
        $field->val([
            [
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
            ], [
                'name' => 'Laura',
                'email' => 'laura@email.com',
                'age' => '35',
                'image' => [
                    'name' => '2.png',
                    'type' => 'image/png',
                    'tmp_name' => '/tmp/phpTobJ72',
                    'error' => 0,
                    'size' => 2297,
                ]
            ],
        ]);

        $this->assertCount(2, $field->val());
        $this->assertEquals('Laura', $field[1]['name']->val());

        $duplicate = $field->getTemplateChild();

        $this->assertEquals('::n::[name]', $duplicate['name']->attr('name'));
        $this->assertEquals('2.png', $field[1]['image']->val()['name']);
    }
}
