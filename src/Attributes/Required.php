<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Required
{
    public static $error_message = 'This value is required';

    /**
     * Callback used on add this attribute to an input.
     *
     * @param InputInterface $input The input in which the attribute will be added
     * @param mixed          $value The value of this attribute
     *
     * @return boolean $value The value sanitized
     */
    public static function onAdd(InputInterface $input, $value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException('The required value must be a boolean');
        }

        $input->addValidator('FormManager\\Validators\\Required::validate');

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input.
     *
     * @param InputInterface $input The input from the attribute will be removed
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Required::validate');
    }
}
