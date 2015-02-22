<?php
use FormManager\Inputs\Input;

class InputCheckboxTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::checkbox());
        $this->_testRequired(Input::checkbox());
        $this->_testCheckUncheck(Input::checkbox());
    }
}
