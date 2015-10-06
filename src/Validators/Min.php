<?php

namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Min
{
    public static $error_message = 'The min value allowed is %s';

    /**
     * Validates the input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(InputInterface $input)
    {
        $value = (string) $input->val();
        $attr = $input->attr('min');

        if (!empty($attr) && $value !== '' && ($value < $attr)) {
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
        $value = (string) $input->val();
        $attr = $input->attr('min');

        if (!empty($attr) && $value !== '' && (strtotime($value) < strtotime($attr))) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
