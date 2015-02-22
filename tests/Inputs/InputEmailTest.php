<?php
use FormManager\Inputs\Input;

class InputEmailTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::email());
        $this->_testRequired(Input::email());
        $this->_testMaxlength(Input::email(), 'o@l.o', 'o@l.com');
    }

    public function testValues()
    {
        $input = Input::email();

        $input->val('invalid-email');
        $this->assertFalse($input->isValid());

        $input->val('valid@email.com');
        $this->assertTrue($input->isValid());
        $this->assertEquals('valid@email.com', $input->val());
    }
}
