<?php
use FormManager\Builder;

class InputTimeTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::time());
        $this->_testField(Builder::time());
        $this->_testRequired(Builder::time());
    }

    public function testsValues()
    {
        $input = Builder::time();

        $input->val('38:34:32');
        $this->assertFalse($input->isValid());

        $input->val('18:34:32');
        $this->assertTrue($input->isValid());
        $this->assertEquals('18:34:32', $input->val());

        $input->max('18:34:31');
        $this->assertFalse($input->isValid());

        $input->max('18:34:32');
        $this->assertTrue($input->isValid());

        $input->max('18:34:33');
        $this->assertTrue($input->isValid());

        $input->min('18:34:33');
        $this->assertFalse($input->isValid());
    }
}
