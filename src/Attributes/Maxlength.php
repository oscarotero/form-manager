<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Maxlength
{
    public static $error_message = 'The max length allowed is %s';

    /**
     * Callback used on add this attribute to an input.
     *
     * @param InputInterface $input The input in which the attribute will be added
     * @param mixed          $value The value of this attribute
     *
     * @return integer $value The value sanitized
     */
    public static function onAdd(InputInterface $input, $value)
    {
        if (!is_int($value) || ($value < 0)) {
            throw new \InvalidArgumentException('The maxlength value must be a non-negative integer');
        }

        $input->addValidator('FormManager\\Validators\\Maxlength::validate');

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input.
     *
     * @param InputInterface $input The input from the attribute will be removed
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Maxlength::validate');
    }
}
