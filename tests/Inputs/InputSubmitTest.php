<?php
use FormManager\Builder;

class InputSubmitTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::submit());
        $this->_testField(Builder::submit(), false);
        $this->_testRequired(Builder::submit());
    }
}
