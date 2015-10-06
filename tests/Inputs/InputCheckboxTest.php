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

    public function testBoolean()
    {
        $input = Builder::checkbox();

        $input->val(0);
        $this->assertNotTrue($input->attr('checked'));

        $input->val(1);
        $this->assertTrue($input->attr('checked'));

        $input->val('off');
        $this->assertNotTrue($input->attr('checked'));

        $input->val('on');
        $this->assertTrue($input->attr('checked'));

        $input->val('0');
        $this->assertNotTrue($input->attr('checked'));

        $input->val('1');
        $this->assertTrue($input->attr('checked'));
    }
}
