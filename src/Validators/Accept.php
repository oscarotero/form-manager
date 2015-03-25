<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Accept
{
    public static $error_message = 'The mime type of this input must be %s';

    /**
     * Validates the input value according to this attribute.
     *
     * @param DataElementInterface $input The input to validate
     *
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(DataElementInterface $input)
    {
        $value = $input->val();

        if (empty($value['tmp_name'])) {
            return true;
        }

        $attr = $input->attr('accept');
        $accept = array_map('trim', explode(',', $attr));
        array_walk($accept, function (&$value) {
            $value = str_replace('*', '.*', "|^{$value}\$|i");
        });

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $value['tmp_name']);
        finfo_close($finfo);

        foreach ($accept as $pattern) {
            if (preg_match($pattern, $mime)) {
                return;
            }
        }

        throw new InvalidValueException(sprintf(static::$error_message, $attr));
    }
}
