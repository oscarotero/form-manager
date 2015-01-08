<?php
namespace FormManager\Attributes;

use FormManager\FormElementInterface;

class Name
{
    /**
     * Callback used on add this attribute to an input
     *
     * @param FormElementInterface $input The input in which the attribute will be added
     * @param mixed          $value The value of this attribute
     *
     * @return mixed $value The value sanitized
     */
    public static function onAdd(FormElementInterface $input, $value)
    {
        if ($input->attr('multiple') && (substr($value, -2) !== '[]')) {
            $value .= '[]';
        }

        return $value;
    }
}
