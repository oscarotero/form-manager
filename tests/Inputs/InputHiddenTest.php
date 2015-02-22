<?php
use FormManager\Inputs\Input;

class InputHiddenTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::hidden());
        $this->_testRequired(Input::hidden());
        $this->_testMaxlength(Input::hidden());
        $this->_testPattern(Input::hidden());
        $this->_testValidator(Input::hidden());
    }
}
