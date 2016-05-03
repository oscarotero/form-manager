<?php

use FormManager\Builder;

class InputDateTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::date());
        $this->_testField(Builder::date());
        $this->_testRequired(Builder::date());
    }

    public function testsValues()
    {
        $input = Builder::date();

        $input->val('2005-33-14');
        $this->assertFalse($input->validate());

        $input->val('Mon, 15 Aug 2005');
        $this->assertTrue($input->validate());
        $this->assertEquals('Mon, 15 Aug 2005', $input->val());

        $input->max('2005-08-14');
        $this->assertFalse($input->validate());

        $input->max('2005-08-15');
        $this->assertTrue($input->validate());

        $input->max('2005-08-16');
        $this->assertTrue($input->validate());

        $input->min('2005-08-16');
        $this->assertFalse($input->validate());
    }
}
