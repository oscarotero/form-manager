<?php
namespace FormManager\Attributes;

use FormManager\Inputs\Input;

class Required
{
    public static $error_message = 'This value is required';

    /**
     * Callback used on add this attribute to an input
     *
     * @param Input $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return boolean $value The value sanitized
     */
    public static function onAdd(Input $input, $value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException('The required value must be a boolean');
        }

        $input->addValidator('required', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input
     *
     * @param Input $input The input from the attribute will be removed
     */
    public static function onRemove(Input $input)
    {
        $input->removeValidator('required');
    }

    /**
     * Validates the input value according to this attribute
     *
     * @param Input $input The input to validate
     *
     * @return boolean|string True if its valid, string with the error if not
     */
    public static function validate(Input $input)
    {
        $value = $input->val();

        //File
        if ($input->attr('type') === 'file') {
            $value = (isset($value['name']) && !empty($value['size'])) ? $value['name'] : null;
        }

        $attr = $input->attr('required');

        return (empty($attr) || !empty($value) || strlen($value) > 0) ? true : sprintf(static::$error_message, $attr);
    }
}
