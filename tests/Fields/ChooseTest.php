<?php
use FormManager\Fields\Field;
use FormManager\Fields\Group;

class ChooseTest extends BaseTest
{
    public function testBase()
    {
        $field = Field::choose([
            'value1' => Field::radio()->label('Value 1'),
            'value2' => Field::radio()->label('Value 2'),
            'value3' => Field::radio()->label('Value 3'),
            'value4' => Field::radio()->label('Value 4'),
        ]);

        $this->assertInstanceOf('FormManager\\Fields\\Choose', $field);
        $this->assertInstanceOf('FormManager\\Fields\\Radio', $field['value1']);
        $this->assertInstanceOf('FormManager\\Label', $field->label);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(Group $field)
    {
        $field->val('value1');

        $this->assertEquals('value1', $field->val());
        $this->assertTrue($field->isValid());
        $this->assertTrue($field['value1']->attr('checked'));
        $this->assertNull($field['value2']->attr('checked'));

        $field->val('invalid-value');

        $this->assertFalse($field->isValid());
        $this->assertEquals('invalid-value', $field->val());
    }
}
