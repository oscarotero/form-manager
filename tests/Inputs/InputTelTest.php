<?php
use FormManager\Inputs\Input;

class InputTelTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::tel());
        $this->_testRequired(Input::tel());
        $this->_testMaxlength(Input::tel());
        $this->_testPattern(Input::tel());
        $this->_testValidator(Input::tel());
    }
}
