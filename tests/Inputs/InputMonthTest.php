<?php

use FormManager\Builder;

class InputMonthTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::month());
        $this->_testField(Builder::month());
        $this->_testRequired(Builder::month());
    }

    public function testsValues()
    {
        $input = Builder::month();

        $input->val('2014-33');
        $this->assertFalse($input->validate());

        $input->val('2014-09');
        $this->assertTrue($input->validate());
        $this->assertEquals('2014-09', $input->val());

        $input->max('2014-08');
        $this->assertFalse($input->validate());

        $input->max('2014-09');
        $this->assertTrue($input->validate());

        $input->max('2014-10');
        $this->assertTrue($input->validate());

        $input->min('2014-10');
        $this->assertFalse($input->validate());
    }
}
