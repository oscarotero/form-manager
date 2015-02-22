<?php
use FormManager\Fields\Field;

class FieldTest extends BaseTest
{
    public function testBase()
    {
        $field = Field::text();

        $this->assertInstanceOf('FormManager\\Fields\\Field', $field);
        $this->assertInstanceOf('FormManager\\Inputs\\Input', $field->input);
        $this->assertInstanceOf('FormManager\\Label', $field->label);

        $this->_testElement(Field::text());
        $this->_testRequired(Field::text());
        $this->_testMaxlength(Field::text());
        $this->_testPattern(Field::text());
        $this->_testValidator(Field::text());
    }

    public function testLabel()
    {
        $field = Field::text();

        $field->label('Label');
        $this->assertEquals('Label', $field->label->html());

        $field->id('my-id');
        $html = '<label for="my-id">Label</label> <input type="text" id="my-id"> ';
        $this->assertEquals($html, $field->toHtml());

        $field->error('Error!!');
        $html .= '<label class="error" for="my-id">Error!!</label>';
        $this->assertEquals($html, $field->toHtml());
    }

    public function testRender()
    {
        $field = Field::text()->name('name')->attr('id', 'field-name')->label('Your name');

        $html = '<label for="field-name">Your name</label> <input type="text" name="name" id="field-name"> ';

        $this->assertEquals($html, (string) $field);

        $field->render(function ($field) {
            return $field->label.'<br>'.$field->input;
        });

        $html = '<label for="field-name">Your name</label><br><input type="text" name="name" id="field-name">';

        $this->assertEquals($html, (string) $field);

        $field->render(function ($field) {
            return '<div>'.$field.'</div>';
        });

        $html = '<div><label for="field-name">Your name</label> <input type="text" name="name" id="field-name"> </div>';

        $this->assertEquals($html, (string) $field);
    }
}
