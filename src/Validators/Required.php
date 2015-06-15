<?php
namespace FormManager\Validators;

use Psr\Http\Message\UploadedFileInterface;
use FormManager\DataElementInterface;
use FormManager\InvalidValueException;

class Required
{
    public static $error_message = 'This value is required';

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

        if ($input->attr('type') === 'file') {
            if ($value instanceof UploadedFileInterface) {
                $value = $value->getSize();
            } else {
                $value = isset($value['size']) ? $value['size'] : null;
            }
        }

        $attr = $input->attr('required');

        if (!empty($attr) && empty($value) && (strlen($value) === 0)) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
