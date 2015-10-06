<?php

use FormManager\Builder;

class InputRadioTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::radio());
        $this->_testField(Builder::radio());
        $this->_testRequired(Builder::radio());
        $this->_testCheckUncheck(Builder::radio());
    }
}
