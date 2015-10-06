<?php

use FormManager\Builder;

class InputPasswordTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::password());
        $this->_testField(Builder::password());
        $this->_testRequired(Builder::password());
        $this->_testMaxlength(Builder::password());
        $this->_testPattern(Builder::password());
        $this->_testValidator(Builder::password());
    }

    public function testValues()
    {
        $input = Builder::password();

        $input->val('hello');
        $this->assertSame('hello', $input->val());
    }
}
