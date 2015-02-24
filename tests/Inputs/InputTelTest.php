<?php
use FormManager\Builder;

class InputTelTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::tel());
        $this->_testRequired(Builder::tel());
        $this->_testMaxlength(Builder::tel());
        $this->_testPattern(Builder::tel());
        $this->_testValidator(Builder::tel());
    }
}
