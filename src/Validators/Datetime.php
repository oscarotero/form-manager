<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Datetime
{
    public static $error_message = 'This value is not a valid datetime';

    protected static $format = 'Y-m-d\TH:i:sP';

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
            return;
        }

        if (!($date = date_create($value))) {
            throw new InvalidValueException(sprintf(static::$error_message, $value));
        }

        $input->val($date->format(static::$format));
    }
}
