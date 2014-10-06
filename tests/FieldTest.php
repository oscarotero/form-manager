<?php
use FormManager\Inputs\Input;
use FormManager\Fields\Field;

include_once __DIR__.'/../src/autoloader.php';

class FieldTest extends PHPUnit_Framework_TestCase
{
    public function testField()
    {
        $field = Field::text();

        $this->assertEquals('text', $field->attr('type'));
        $this->assertEquals('text', $field->input->attr('type'));

        $field->label('Label');
        $this->assertEquals('Label', $field->label->html());

        $field->id('my-id');
        $html = '<label for="my-id">Label</label> <input type="text" id="my-id"> ';
        $this->assertEquals($html, $field->toHtml());

        $field->error('Error!!');
        $html .= '<label class="error" for="my-id">Error!!</label>';
        $this->assertEquals($html, $field->toHtml());
    }

    public function testDuplicableField()
    {
        $field = Field::duplicable([
            'name' => Field::text()->label('Name'),
            'email' => Field::email()->label('email'),
            'age' => Field::number()->label('Age')
        ]);

        $field->val([
            [
                'name' => 'Oscar',
                'email' => 'oscar@email.com',
                'age' => '35'
            ],[
                'name' => 'Laura',
                'email' => 'laura@email.com',
                'age' => '35'
            ]
        ]);

        $this->assertCount(2, $field->val());
        $this->assertEquals('Laura', $field[1]['name']->val());

        $duplicate = $field->getDuplicate();
        $this->assertEquals('::n::[name]', $duplicate['name']->attr('name'));
    }
}
