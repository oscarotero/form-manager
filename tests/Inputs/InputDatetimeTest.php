<?php
use FormManager\Inputs\Input;

class InputDatetimeTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::datetime());
        $this->_testRequired(Input::datetime());
    }

    public function testDatetimeValues()
    {
        $input = Input::datetime();

        $input->val('2005-33-14T15:52:01+00:00');
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2005 15:52:01 +0000');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2005-08-15T15:52:01+00:00', $input->val());
    }

    public function testMinMaxDatetime()
    {
        $input = Input::datetime();

        $input->min('2004-08-14T15:52:01+00:00');
        $input->max('2005-08-14T15:52:01+00:00');

        $input->val('Mon, 15 Aug 2005 15:52:01 +0000');
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2004 15:52:01 +0000');
        $this->assertTrue($input->isValid());
    }
}
