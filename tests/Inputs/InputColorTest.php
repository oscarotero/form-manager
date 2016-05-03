<?php

use FormManager\Builder;

class InputColorTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::color());
        $this->_testField(Builder::color());
        $this->_testRequired(Builder::color());
    }

    public function testsValues()
    {
        $input = Builder::color();

        $input->val('red');
        $this->assertFalse($input->validate());

        $input->val('11234f');
        $this->assertFalse($input->validate());

        $input->val('#11234f');
        $this->assertTrue($input->validate());
        $this->assertEquals('#11234f', $input->val());
    }
}
