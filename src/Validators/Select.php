<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Select
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
        if (!($value = $input->val())) {
            return null;
        }

        if ($input->attr('multiple')) {
            if (array_keys(array_diff_key(array_flip($value), $input()))) {
                throw new InvalidValueException(sprintf(static::$error_message));
            }
        } elseif (!isset($input[$value])) {
            throw new InvalidValueException(sprintf(static::$error_message));
        }
    }
}
