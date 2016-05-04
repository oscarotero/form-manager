<?php

namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Datetime
{
    public static $error_message = [
        'date' => 'This value is not a valid date',
        'datetime' => 'This value is not a valid datetime',
        'datetimelocal' => 'This value is not a valid local datetime',
        'month' => 'This value is not a valid month',
        'time' => 'This value is not a valid time',
        'week' => 'This value is not a valid week',
    ];

    /**
     * Validates the input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(InputInterface $input)
    {
        if (!($value = $input->val())) {
            return;
        }

        if (!($date = date_create($value))) {
            $type = $input->attr('type');
            $message = isset(static::$error_message[$type]) ? static::$error_message[$type] : 'Invalid datetime value';
            throw new InvalidValueException(sprintf($message, $value));
        }
    }
}
