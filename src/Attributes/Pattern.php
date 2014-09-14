<?php
namespace FormManager\Attributes;

class Pattern
{
    public static $error_message = 'This value is not valid';

    /**
     * Callback used on add this attribute to an input
     *
     * @param InputInterface $input The input in which the attribute will be added
     * @param mixed          $value The value of this attribute
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd($input, $value)
    {
        $input->addValidator('pattern', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input
     *
     * @param InputInterface $input The input from the attribute will be removed
     */
    public static function onRemove($input)
    {
        $input->removeValidator('pattern');
    }

    /**
     * Validates the input value according to this attribute
     *
     * @param InputInterface $input The input to validate
     *
     * @return string|true True if its valid, string with the error if not
     */
    public static function validate($input)
    {
        $value = $input->val();

        //File
        if ($input->attr('type') === 'file') {
            $value = isset($value['name']) ? $value['name'] : null;
        }

        $attr = str_replace('/', '\\/', $input->attr('pattern'));

        return (empty($attr) || empty($value) || filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^{$attr}\$/")))) ? true : sprintf(static::$error_message, $attr);
    }
}
