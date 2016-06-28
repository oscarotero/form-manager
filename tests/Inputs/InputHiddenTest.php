<?php

use FormManager\Builder;

class InputHiddenTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::hidden());
        $this->_testField(Builder::hidden(), false, false);
        $this->_testRequired(Builder::hidden());
        $this->_testMaxlength(Builder::hidden());
        $this->_testPattern(Builder::hidden());
        $this->_testValidator(Builder::hidden());
    }

    public function testRender()
    {
        $input = Builder::hidden()->name('foo')->val('bar');

        $this->assertSame('<input type="hidden" name="foo" value="bar">', (string) $input);
    }
}
