<?php
use FormManager\Builder;

class InputUrlTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::url());
        $this->_testField(Builder::url());
        $this->_testRequired(Builder::url());
        $this->_testMaxlength(Builder::url(), 'http://o.a', 'http://ola.com', 10);
    }

    public function testValues()
    {
        $input = Builder::url();

        $input->val('invalid-url');
        $this->assertFalse($input->isValid());

        $input->val('http://valid-url.com');
        $this->assertTrue($input->isValid());
        $this->assertEquals('http://valid-url.com', $input->val());
    }
}
