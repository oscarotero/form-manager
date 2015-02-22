<?php
use FormManager\Inputs\Input;

class InputNumberTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::number());
        $this->_testRequired(Input::number());
        $this->_testNumber(Input::number());
        $this->_testMinMax(Input::number());
        $this->_testMaxlength(Input::number(), 12345, 123456);
        $this->_testMaxlength(Input::number(), 12.34, 12.345);
    }
}
