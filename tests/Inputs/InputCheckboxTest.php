<?php
use FormManager\Builder;

class InputCheckboxTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::checkbox());
        $this->_testRequired(Builder::checkbox());
        $this->_testCheckUncheck(Builder::checkbox());
    }
}
