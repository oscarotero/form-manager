<?php
namespace FormManager\Attributes;

use FormManager\Inputs\Input;

class Max
{
    public static $error_message = 'The max value allowed is %s';

    /**
     * Callback used on add this attribute to an input
     *
     * @param Input $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd(Input $input, $value)
    {
        switch ($input->attr('type')) {
            case 'datetime':
            case 'datetime-local':
            case 'date':
            case 'time':
            case 'month':
            case 'week':
                return self::checkDatetimeAttribute($input, $value);

            default:
                return self::checkAttribute($input, $value);
        }
    }

    /**
     * Callback used on add this attribute to an input
     *
     * @param Input $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return mixed The value sanitized
     */
    protected static function checkAttribute(Input $input, $value)
    {
        if (!is_float($value) && !is_int($value)) {
            throw new \InvalidArgumentException('The max value must be a float number');
        }

        $input->addValidator('max', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on add this attribute to a datetime input
     *
     * @param Input $input The input in which the attribute will be added
     * @param mixed $value The value of this attribute
     *
     * @return mixed The value sanitized
     */
    protected static function checkDatetimeAttribute(Input $input, $value)
    {
        if (!date_create($value)) {
            throw new \InvalidArgumentException('The max value must be a valid datetime');
        }

        $input->addValidator('max', array(__CLASS__, 'validateDatetime'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input
     *
     * @param Input $input The input from the attribute will be removed
     */
    public static function onRemove(Input $input)
    {
        $input->removeValidator('max');
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
        $attr = $input->attr('max');

        return (empty($attr) || ($value <= $attr)) ? true : sprintf(static::$error_message, $attr);
    }

    /**
     * Validates the datetime input value according to this attribute
     *
     * @param Input $input The input to validate
     *
     * @return boolean|string True if its valid, string with the error if not
     */
    public static function validateDatetime(Input $input)
    {
        $value = $input->val();
        $attr = $input->attr('max');

        return (empty($attr) || (strtotime($value) <= strtotime($attr))) ? true : sprintf(static::$error_message, $attr);
    }
}
