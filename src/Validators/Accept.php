<?php
namespace FormManager\Validators;

use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Accept
{
    public static $error_message = 'The mime type of this input must be %s';

    /**
     * Validates the input value according to this attribute.
     *
     * @param InputInterface $input The input to validate
     * 
     * @throws InvalidValueException If the value is not valid
     */
    public static function validate(InputInterface $input)
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

        if (array_search($mime, $accept) === false) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
