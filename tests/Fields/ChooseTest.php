<?php
use FormManager\Builder;
use FormManager\Containers\Choose;

class ChooseTest extends BaseTest
{
    public function testBase()
    {
        $field = Builder::choose([
            'value1' => Builder::radio()->label('Value 1'),
            'value2' => Builder::radio()->label('Value 2'),
            'value3' => Builder::radio()->label('Value 3'),
            'value4' => Builder::radio()->label('Value 4'),
        ]);

        $this->assertInstanceOf('FormManager\\Containers\\Choose', $field);
        $this->assertInstanceOf('FormManager\\Inputs\\Radio', $field['value1']);

        return $field;
    }

    /**
     * @depends testBase
     */
    public function testValue(Choose $field)
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
