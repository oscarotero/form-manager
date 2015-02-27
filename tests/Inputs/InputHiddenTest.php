<?php
use FormManager\Builder;

class InputHiddenTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::hidden());
        $this->_testField(Builder::hidden(), false);
        $this->_testRequired(Builder::hidden());
        $this->_testMaxlength(Builder::hidden());
        $this->_testPattern(Builder::hidden());
        $this->_testValidator(Builder::hidden());
    }
}
