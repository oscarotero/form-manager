<?php
use FormManager\Inputs\Input;

class InputPasswordTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::password());
        $this->_testRequired(Input::password());
        $this->_testMaxlength(Input::password());
        $this->_testPattern(Input::password());
        $this->_testValidator(Input::password());
    }

    public function testValues()
    {
        $input = Input::password();

        $input->val('hello');
        $this->assertSame('hello', $input->val());
    }
}
