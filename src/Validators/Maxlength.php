<?php
namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Maxlength
{
    public static $error_message = 'The max length allowed is %s';

    /**
     * Validates the input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(InputInterface $input)
    {
        $value = $input->val();
        $attr = $input->attr('maxlength');

        if (!empty($attr) && (strlen($value) > $attr)) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
