<?php
namespace FormManager\Validators;

use Psr\Http\Message\UploadedFileInterface;
use FormManager\InputInterface;
use FormManager\InvalidValueException;

class Pattern
{
    public static $error_message = 'This value is not valid';

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

        if ($input->attr('type') === 'file') {
            if ($value instanceof UploadedFileInterface) {
                $value = $value->getClientFilename();
            } else {
                $value = isset($value['name']) ? $value['name'] : null;
            }
        }

        $attr = str_replace('/', '\\/', $input->attr('pattern'));

        if (!empty($attr) && !empty($value) && !filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^{$attr}\$/")))) {
            throw new InvalidValueException(sprintf(static::$error_message, $attr));
        }
    }
}
