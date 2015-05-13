<?php
use FormManager\Builder;

class InputSearchTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::search());
        $this->_testField(Builder::search());
        $this->_testRequired(Builder::search());
        $this->_testMaxlength(Builder::search());
        $this->_testPattern(Builder::search());
        $this->_testValidator(Builder::search());
    }

    public function testValues()
    {
        $input = Builder::search();

        $input->val('hello');
        $this->assertSame('hello', $input->val());

        $input->val('0');
        $this->assertSame('0', $input->val());

        $input->load('0');
        $this->assertSame('0', $input->val());
    }
}
