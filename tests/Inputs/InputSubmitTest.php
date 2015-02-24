<?php
use FormManager\Builder;

class InputSubmitTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::submit());
        $this->_testRequired(Builder::submit());
    }
}
