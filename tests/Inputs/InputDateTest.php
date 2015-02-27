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
        $this->assertFalse($input->isValid());

        $input->val('Mon, 15 Aug 2005');
        $this->assertTrue($input->isValid());
        $this->assertEquals('2005-08-15', $input->val());

        $input->max('2005-08-14');
        $this->assertFalse($input->isValid());

        $input->max('2005-08-15');
        $this->assertTrue($input->isValid());

        $input->max('2005-08-16');
        $this->assertTrue($input->isValid());

        $input->min('2005-08-16');
        $this->assertFalse($input->isValid());
    }
}
