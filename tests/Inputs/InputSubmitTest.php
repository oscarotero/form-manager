<?php
use FormManager\Inputs\Input;

class InputSubmitTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::submit());
        $this->_testRequired(Input::submit());
    }
}
