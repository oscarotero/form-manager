<?php
use FormManager\Inputs\Input;

class InputTextareaTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::textarea());
        $this->_testRequired(Input::textarea());
        $this->_testMaxlength(Input::textarea());
        $this->_testPattern(Input::textarea());
        $this->_testValidator(Input::textarea());
    }
}
