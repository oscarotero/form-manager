<?php
use FormManager\Inputs\Input;

class InputSearchTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::search());
        $this->_testRequired(Input::search());
        $this->_testMaxlength(Input::search());
        $this->_testPattern(Input::search());
        $this->_testValidator(Input::search());
    }

    public function testValues()
    {
        $input = Input::search();

        $input->val('hello');
        $this->assertSame('hello', $input->val());
    }
}
