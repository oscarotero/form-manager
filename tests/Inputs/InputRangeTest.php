<?php
use FormManager\Inputs\Input;

class InputRangeTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::range());
        $this->_testRequired(Input::range());
        $this->_testNumber(Input::range());
        $this->_testMinMax(Input::range());
    }
}
