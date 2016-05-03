<?php

use FormManager\Builder;

class InputWeekTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::week());
        $this->_testField(Builder::week());
        $this->_testRequired(Builder::week());
    }

    public function testsValues()
    {
        $input = Builder::week();

        $input->val('2014-W55');
        $this->assertFalse($input->validate());

        $input->val('2014-W16');
        $this->assertTrue($input->validate());
        $this->assertEquals('2014-W16', $input->val());

        $input->max('2014-W15');
        $this->assertFalse($input->validate());

        $input->max('2014-W16');
        $this->assertTrue($input->validate());

        $input->max('2014-W17');
        $this->assertTrue($input->validate());

        $input->min('2014-W17');
        $this->assertFalse($input->validate());
    }
}
