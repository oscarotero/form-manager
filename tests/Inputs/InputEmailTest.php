<?php

use FormManager\Builder;

class InputEmailTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::email());
        $this->_testField(Builder::email());
        $this->_testRequired(Builder::email());
        $this->_testMaxlength(Builder::email(), 'o@l.o', 'o@l.com');
    }

    public function testValues()
    {
        $input = Builder::email();

        $input->val('invalid-email');
        $this->assertFalse($input->validate());

        $input->val('valid@email.com');
        $this->assertTrue($input->validate());
        $this->assertEquals('valid@email.com', $input->val());
    }
}
