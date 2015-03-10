<?php
namespace FormManager\Validators;

use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class File
{
    public static $error_message = [
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
    ];

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

        if (isset($value['error']) && isset(self::$error_message[$value['error']])) {
            throw new InvalidValueException(sprintf(static::$error_message[$value['error']]));
        }
    }
}
