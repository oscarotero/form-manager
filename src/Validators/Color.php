<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Color
{
    public static $error_message = 'This value is not a valid color';

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

        if (!empty($value) && !preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            throw new InvalidValueException(sprintf(static::$error_message, $value));
        }
    }
}
