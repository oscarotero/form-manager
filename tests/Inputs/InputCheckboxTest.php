<?php

use FormManager\Builder;

class InputCheckboxTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::checkbox());
        $this->_testField(Builder::checkbox());
        $this->_testRequired(Builder::checkbox());
        $this->_testCheckUncheck(Builder::checkbox());
    }

    public function booleanProvider()
    {
        return [
            [0, false],
            [1, true],
            ['off', false],
            ['on', true],
            ['0', false],
            ['1', true],
        ];
    }

    /**
     * @dataProvider booleanProvider
     */
    public function testBoolean($value, $checked)
    {
        $input = Builder::checkbox();

        $input->val($value);

        if ($checked) {
            $this->assertTrue($input->attr('checked'));
        } else {
            $this->assertNotTrue($input->attr('checked'));
        }

        $input->load($value);

        if ($checked) {
            $this->assertTrue($input->attr('checked'));
        } else {
            $this->assertNotTrue($input->attr('checked'));
        }
    }
}
