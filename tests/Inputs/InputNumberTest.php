<?php
use FormManager\Builder;

class InputNumberTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::number());
        $this->_testField(Builder::number());
        $this->_testRequired(Builder::number());
        $this->_testNumber(Builder::number());
        $this->_testMinMax(Builder::number());
        $this->_testMaxlength(Builder::number(), 12345, 123456);
        $this->_testMaxlength(Builder::number(), 12.34, 12.345);
    }

    public function testEmptyWithMinValue()
    {
        $number = Builder::number()->min(1)->val('');

        $this->assertTrue($number->isValid());

        $number->required();
 
        $this->assertFalse($number->isValid());
    }
}
