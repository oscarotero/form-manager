<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;

class Required
{
    public static $error_message = 'This value is required';

    /**
     * Callback used on add this attribute to an input.
     *
     * @param InputInterface $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return boolean $value The value sanitized
     */
    public static function onAdd(InputInterface $input, $value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException('The required value must be a boolean');
        }

        $input->addValidator('required', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input.
     *
     * @param InputInterface $input The input from the attribute will be removed
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('required');
    }

    /**
     * Validates the input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     *
     * @return boolean|string True if its valid, string with the error if not
     */
    public static function validate(InputInterface $input)
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
