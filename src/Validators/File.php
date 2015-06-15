<?php
namespace FormManager\Validators;

use Psr\Http\Message\UploadedFileInterface;
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
        $error = null;

        if ($value instanceof UploadedFileInterface) {
            $error = $value->getError();
        } else if (isset($value['error'])) {
            $error = $value['error'];
        }


        if ($error !== null && isset(self::$error_message[$error])) {
            throw new InvalidValueException(sprintf(static::$error_message[$error]));
        }
    }
}
