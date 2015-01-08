<?php
namespace FormManager\Attributes;

use FormManager\Inputs\Input;

class Accept
{
    public static $error_message = 'The mime type of this input must be %s';

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
        $input->addValidator('accept', array(__CLASS__, 'validate'));

        return $value;
    }

    /**
     * Callback used on remove this attribute from an input
     *
     * @param Input $input The input from the attribute will be removed
     */
    public static function onRemove(Input $input)
    {
        $input->removeValidator('accept');
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

        if (empty($value['tmp_name'])) {
            return true;
        }

        $attr = $input->attr('accept');
        $accept = array_map('trim', explode(',', $attr));
        $filename = $value['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $filename);
        finfo_close($finfo);

        return (array_search($mime, $accept) !== false) ? true : sprintf(static::$error_message, $attr);
    }
}
