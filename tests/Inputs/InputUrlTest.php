<?php
use FormManager\Inputs\Input;

class InputUrlTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::url());
        $this->_testRequired(Input::url());
        $this->_testMaxlength(Input::url(), 'http://o.a', 'http://ola.com', 10);
    }

    public function testValues()
    {
        $input = Input::url();

        $input->val('invalid-url');
        $this->assertFalse($input->isValid());

        $input->val('http://valid-url.com');
        $this->assertTrue($input->isValid());
        $this->assertEquals('http://valid-url.com', $input->val());
    }
}
