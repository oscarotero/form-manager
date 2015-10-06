<?php

use FormManager\Builder;

class InputTextareaTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::textarea());
        $this->_testField(Builder::textarea());
        $this->_testRequired(Builder::textarea());
        $this->_testMaxlength(Builder::textarea());
        $this->_testPattern(Builder::textarea());
        $this->_testValidator(Builder::textarea());
    }
}
