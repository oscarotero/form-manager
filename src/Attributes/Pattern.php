<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Pattern
{
    public static $error_message = 'This value is not valid';

    /**
     * Callback used on add this attribute to an input.
     *
     * @param InputInterface $input The input in which the attribute will be added
     * @param mixed          $value The value of this attribute
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd(InputInterface $input, $value)
    {
        $input->addValidator('FormManager\\Validators\\Pattern::validate');

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input.
     *
     * @param InputInterface $input The input from the attribute will be removed
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Pattern::validate');
    }
}
