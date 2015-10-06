<?php

namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Max
{
    public static $error_message = 'The max value allowed is %s';

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
        $attr = $input->attr('max');

        if (!empty($attr) && ($value > $attr)) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }

    /**
     * Validates the datetime input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validateDatetime(InputInterface $input)
    {
        $value = $input->val();
        $attr = $input->attr('max');

        if (!empty($attr) && (strtotime($value) > strtotime($attr))) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
