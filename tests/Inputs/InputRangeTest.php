<?php

use FormManager\Builder;

class InputRangeTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::range());
        $this->_testField(Builder::range());
        $this->_testRequired(Builder::range());
        $this->_testNumber(Builder::range());
        $this->_testMinMax(Builder::range());
    }
}
