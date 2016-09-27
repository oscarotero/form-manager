<?php

use FormManager\Inputs\Input;
use FormManager\InvalidValueException;
use FormManager\Builder;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    protected function _testNameAttributeException($element)
    {
        try {
            $element->attr('name', 'new-name');
        } catch (InvalidArgumentException $exception) {
        }

        $this->assertInstanceOf('InvalidArgumentException', $exception);
    }

    protected function _testElement($element)
    {
        //Id attribute
        $this->assertSame($element->id('input-id'), $element);
        $this->assertEquals('input-id', $element->attr('id'));
        $this->assertNull($element->val());

        //Name
        $this->assertNull($element->data('name'));
        $element->attr('name', 'new-name');
        $this->assertEquals('new-name', $element->attr('name'));
        $group = Builder::group();
        $group['my-name'] = $element;
        $this->assertEquals('my-name', $element->attr('name'));
        $this->_testNameAttributeException($element);

        //Data
        $element->data('boolean-value', true);
        $this->assertTrue($element->data('boolean-value'));
        $this->assertSame($element->data('name', 'value'), $element);
        $this->assertEquals('value', $element->data('name'));
        $this->assertEquals(['name' => 'value', 'boolean-value' => true], $element->data());

        //Add, remove classes
        $this->assertNull($element->attr('class'));
        $this->assertSame($element->addClass('first'), $element);
        $element->addClass('second');
        $this->assertEquals('first second', $element->attr('class'));

        $this->assertSame($element->removeClass('second'), $element);
        $this->assertEquals('first', $element->attr('class'));

        //Arbitrary values
        $this->assertSame($element->set('myVar', ['one', 'two']), $element);
        $this->assertEquals(['one', 'two'], $element->get('myVar'));

        $element->set('var1', true);
        $this->assertTrue($element->get('var1'));
        $element->set(['var1' => false, 'var2' => true]);
        $this->assertFalse($element->get('var1'));
        $this->assertTrue($element->get('var2'));
    }

    protected function _testField($field, $isContainer = false, $hasLabel = true)
    {
        $this->assertInstanceOf('FormManager\\FieldInterface', $field);

        if ($isContainer) {
            $this->assertInstanceOf('FormManager\\Fields\\FieldContainer', $field);
            $this->assertInstanceOf('FormManager\\Elements\\ElementContainer', $field->input);
        } else {
            $this->assertInstanceOf('FormManager\\Fields\\Field', $field);
            $this->assertInstanceOf('FormManager\\Elements\\Element', $field->input);
        }

        //Error labels
        $field->required();

        $field->validate();

        if ($hasLabel) {
            $this->assertInstanceOf('FormManager\\Elements\\Label', $field->label);
            $this->assertInstanceOf('FormManager\\Elements\\Label', $field->errorLabel);

            $field->labelAttr(['class' => 'field']);
            $this->assertTrue($field->label->hasClass('field'));
        }
    }

    protected function _testRequired($input, $value = null)
    {
        $input->required();

        $input->val($value);

        $this->assertFalse($input->validate());
    }

    protected function _testCheckUncheck($input)
    {
        $this->assertNull($input->attr('checked'));

        $input->check();
        $this->assertTrue($input->attr('checked'));

        $input->uncheck();
        $this->assertNull($input->attr('checked'));

        $input->attr('value', 'world');
        $input->load('world');

        $this->assertTrue($input->attr('checked'));

        $input->load('mars');
        $this->assertNull($input->attr('checked'));
    }

    protected function _testNumber($input)
    {
        $input->val('not a number');
        $this->assertFalse($input->validate());

        $input->val('25');
        $this->assertTrue($input->validate());
        $this->assertEquals('25', $input->val());

        $input->val('25.5');
        $this->assertTrue($input->validate());

        $input->val('');
        $this->assertTrue($input->validate());

        $input->val('0');
        $this->assertTrue($input->validate());

        $input->val('0.00');
        $this->assertTrue($input->validate());
    }

    protected function _testMinMax($input)
    {
        $input->min(10);
        $input->max(20);

        $input->val(10);
        $this->assertTrue($input->validate());

        $input->val(20);
        $this->assertTrue($input->validate());

        $input->val(9);
        $this->assertFalse($input->validate());

        $input->val(21);
        $this->assertFalse($input->validate());

        $input->val(9.99);
        $this->assertFalse($input->validate());

        $input->val(20.01);
        $this->assertFalse($input->validate());
    }

    protected function _testMaxlength($input, $success = 'strin', $fail = 'string', $max = 5)
    {
        $input->maxlength($max);

        $input->val($success);
        $this->assertTrue($input->validate());

        $input->val($fail);
        $this->assertFalse($input->validate());
    }

    protected function _testPattern($input)
    {
        $input->pattern('[0-9]');

        $input->val('0');
        $this->assertTrue($input->validate());

        $input->val('a');
        $this->assertFalse($input->validate());

        $input->pattern('/[a-z]{2}/');

        $input->val('/a/');
        $this->assertFalse($input->validate());

        $input->val('/ab/');
        $this->assertTrue($input->validate());
    }

    /**
     * @expectedException FormManager\Exception\ItemNotFoundException
     */
    protected function _testValidator($input)
    {
        $input->addValidator('isDave', function($input){
            if($input->val() != 'dave'){
                throw new InvalidValueException('This value must be dave');
            }
        });

        $input->removeAttr('pattern');
        $input->val('dave');
        $this->assertTrue($input->validate());

        $input->val('notDave');
        $this->assertFalse($input->validate());

        $input->removeValidator('isDave');
        $input->val('notDave');
        $this->assertTrue($input->validate());
    }


}
