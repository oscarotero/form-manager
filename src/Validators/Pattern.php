<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Pattern
{
    public static $error_message = 'This value is not valid';

    /**
     * Validates the input value according to this attribute.
     *
     * @param DataElementInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(DataElementInterface $input)
    {
        $value = $input->val();

        //File
        if ($input->attr('type') === 'file') {
            $value = isset($value['name']) ? $value['name'] : null;
        }

        $attr = str_replace('/', '\\/', $input->attr('pattern'));

        if (!empty($attr) && !empty($value) && !filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^{$attr}\$/")))) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
