<?php
use FormManager\Inputs\Input;
use FormManager\InvalidValueException;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    protected function _testElement($element)
    {
        //Name
        $element->name('input-name');
        $this->assertEquals('input-name', $element->attr('name'));
        $this->assertNull($element->val());

        //Data
        $element->data('name', 'value');
        $this->assertEquals('value', $element->data('name'));
        $this->assertEquals(['name' => 'value'], $element->data());

        //Add, remove classes
        $this->assertNull($element->attr('class'));
        $element->addClass('first');
        $element->addClass('second');
        $this->assertEquals('first second', $element->attr('class'));

        $element->removeClass('second');
        $this->assertEquals('first', $element->attr('class'));

        //Arbitrary values
        $element->set('myVar', ['one', 'two']);
        $this->assertEquals(['one', 'two'], $element->get('myVar'));
    }

    protected function _testRequired($input, $value = null)
    {
        $input->required();

        $input->val($value);

        $this->assertFalse($input->isValid());
    }

    protected function _testCheckUncheck($input)
    {
        $this->assertNull($input->attr('checked'));

        $input->check();
        $this->assertTrue($input->attr('checked'));

        $input->uncheck();
        $this->assertNull($input->attr('checked'));

        $input->val('world');
        $input->load('world');

        $this->assertTrue($input->attr('checked'));

        $input->load('mars');
        $this->assertNull($input->attr('checked'));
    }

    protected function _testNumber($input)
    {
        $input->val('not a number');
        $this->assertFalse($input->isValid());

        $input->val('25');
        $this->assertTrue($input->isValid());
        $this->assertEquals('25', $input->val());

        $input->val('25.5');
        $this->assertTrue($input->isValid());

        $input->val('');
        $this->assertTrue($input->isValid());

        $input->val('0');
        $this->assertTrue($input->isValid());
    }

    protected function _testMinMax($input)
    {
        $input->min(10);
        $input->max(20);

        $input->val(10);
        $this->assertTrue($input->isValid());

        $input->val(20);
        $this->assertTrue($input->isValid());

        $input->val(9);
        $this->assertFalse($input->isValid());

        $input->val(21);
        $this->assertFalse($input->isValid());

        $input->val(9.99);
        $this->assertFalse($input->isValid());

        $input->val(20.01);
        $this->assertFalse($input->isValid());
    }

    protected function _testMaxlength($input, $success = 'strin', $fail = 'string', $max = 5)
    {
        $input->maxlength($max);

        $input->val($success);
        $this->assertTrue($input->isValid());

        $input->val($fail);
        $this->assertFalse($input->isValid());
    }

    protected function _testPattern($input)
    {
        $input->pattern('[0-9]');

        $input->val('0');
        $this->assertTrue($input->isValid());

        $input->val('a');
        $this->assertFalse($input->isValid());

        $input->pattern('/[a-z]{2}/');

        $input->val('/a/');
        $this->assertFalse($input->isValid());

        $input->val('/ab/');
        $this->assertTrue($input->isValid());
    }

    protected function _testValidator($input)
    {
        $input->addValidator(function ($input) {
            if ($input->val() !== 'dave') {
                throw new InvalidValueException('This value must be "dave"');
            };
        });

        $this->assertFalse($input->isValid());

        $input->removeAttr('pattern');
        $input->val('dave');

        $this->assertTrue($input->isValid());
    }
}
