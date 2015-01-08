<?php
namespace FormManager\Attributes;

use FormManager\Inputs\Input;

class Pattern
{
    public static $error_message = 'This value is not valid';

    /**
     * Callback used on add this attribute to an input
     *
     * @param Input $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd(Input $input, $value)
    {
        $input->addValidator('pattern', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input
     *
     * @param Input $input The input from the attribute will be removed
     */
    public static function onRemove(Input $input)
    {
        $input->removeValidator('pattern');
    }

    /**
     * Validates the input value according to this attribute
     *
     * @param Input $input The input to validate
     *
     * @return boolean|string True if its valid, string with the error if not
     */
    public static function validate(Input $input)
    {
        $value = $input->val();

        //File
        if ($input->attr('type') === 'file') {
            $value = isset($value['name']) ? $value['name'] : null;
        }

        $attr = str_replace('/', '\\/', $input->attr('pattern'));

        return (empty($attr) || empty($value) || filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^{$attr}\$/")))) ? true : sprintf(static::$error_message, $attr);
    }
}
