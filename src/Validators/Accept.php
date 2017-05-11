<?php

namespace FormManager\Validators;

use Psr\Http\Message\UploadedFileInterface;
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

        //Psr UploadeFileInterface validation
        if ($value instanceof UploadedFileInterface) {
            if ($value->getError() === UPLOAD_ERR_NO_FILE) {
                return;
            }

            return static::validateName(
                $value->getStream()->getMetadata('uri'),
                $value->getClientFilename(),
                $input->attr('accept')
            );
        }

        if (empty($value['tmp_name'])) {
            return true;
        }

        static::validateName($value['tmp_name'], $value['name'], $input->attr('accept'));
    }

    /**
     * Validate the file extension and mimetype
     *
     * @param string $file The file path
     * @param string $name The original file name
     * @param string $attr The value of the accept attribute
     *
     * @throws InvalidValueException If the value is not valid
     */
    protected static function validateName($file, $name, $attr)
    {
        $accept = array_map('trim', explode(',', strtolower($attr)));

        $extensions = array_filter($accept, function($value) {
            return !strstr($value, '/');
        });

        $mimes = array_filter($accept, function($value) {
            return strstr($value, '/');
        });

        if (static::validateExtension($name, $extensions) || static::validateMime($file, $mimes)) {
            return;
        }

        throw new InvalidValueException(sprintf(static::$error_message, $attr));
    }

    /**
     * Validate the file extension
     *
     * @param string $name The original file name
     * @param string $extensions Allowed extensions
     *
     * @return bool
     */
    protected static function validateExtension($name, $extensions)
    {
        if (empty($extensions)) {
            return;
        }

        $original = explode('.', $name);
        $original = '.'.end($original);

        foreach ($extensions as $extension) {
            if ($original = $extension) {
                return true;
            }
        }
    }

    /**
     * Validate the file mimetype
     *
     * @param string $file The original file path
     * @param string $mimes Allowed mimetypes
     *
     * @return bool
     */
    protected static function validateMime($file, $mimes)
    {
        if (empty($mimes)) {
            return;
        }

        array_walk($mimes, function (&$value) {
            $value = str_replace('*', '.*', "|^{$value}\$|i");
        });

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        foreach ($mimes as $pattern) {
            if (preg_match($pattern, $mime)) {
                return true;
            }
        }
    }
}
