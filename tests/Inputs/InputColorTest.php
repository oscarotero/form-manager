<?php
use FormManager\Inputs\Input;

class InputColorTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Input::color());
        $this->_testRequired(Input::color());
    }

    public function testsValues()
    {
        $input = Input::color();

        $input->val('red');
        $this->assertFalse($input->isValid());

        $input->val('11234f');
        $this->assertFalse($input->isValid());

        $input->val('#11234f');
        $this->assertTrue($input->isValid());
        $this->assertEquals('#11234f', $input->val());
    }
}
