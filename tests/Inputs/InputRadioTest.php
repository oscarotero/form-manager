<?php
use FormManager\Inputs\Input;

class InputRadioTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::radio());
        $this->_testRequired(Input::radio());
        $this->_testCheckUncheck(Input::radio());
    }
}
