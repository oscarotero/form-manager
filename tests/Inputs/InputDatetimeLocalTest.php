<?php

use FormManager\Builder;

class InputDatetimeLocalTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::datetimeLocal());
        $this->_testField(Builder::datetimeLocal());
        $this->_testRequired(Builder::datetimeLocal());
    }

    public function testDatetimeValues()
    {
        $input = Builder::datetimeLocal();

        $input->val('2005-33-14T15:52:01+00:00');
        $this->assertFalse($input->validate());

        $input->val('Mon, 15 Aug 2005 15:52:01 +0000');
        $this->assertTrue($input->validate());
        $this->assertEquals('Mon, 15 Aug 2005 15:52:01 +0000', $input->val());
    }

    public function testMinMaxDatetime()
    {
        $input = Builder::datetimeLocal();

        $input->min('2004-08-14T15:52:01');
        $input->max('2005-08-14T15:52:01');

        $input->val('Mon, 15 Aug 2005 15:52:01');
        $this->assertFalse($input->validate());

        $input->val('Mon, 15 Aug 2004 15:52:01');
        $this->assertTrue($input->validate());
    }
}
