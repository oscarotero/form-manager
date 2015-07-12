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

            return static::validateMime($value->getStream()->getMetadata('uri'), $input->attr('accept'));
        }

        if (empty($value['tmp_name'])) {
            return true;
        }

        static::validateMime($value['tmp_name'], $input->attr('accept'));
    }

    /**
     * Get and validate the mimetype
     *
     * @param string $file The file path
     * @param string $attr The value of the accept attribute
     */
    protected static function validateMime($file, $attr)
    {
        $accept = array_map('trim', explode(',', $attr));

        array_walk($accept, function (&$value) {
            $value = str_replace('*', '.*', "|^{$value}\$|i");
        });

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);

        foreach ($accept as $pattern) {
            if (preg_match($pattern, $mime)) {
                return;
            }
        }

        throw new InvalidValueException(sprintf(static::$error_message, $attr));
    }
}
