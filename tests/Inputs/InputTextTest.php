<?php
use FormManager\Inputs\Input;

class InputTextTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::text());
        $this->_testRequired(Input::text());
        $this->_testMaxlength(Input::text());
        $this->_testPattern(Input::text());
        $this->_testValidator(Input::text());
    }
}
