<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

class Maxlength implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(DataElementInterface $input, $value)
    {
        if (!is_int($value) || ($value < 0)) {
            throw new \InvalidArgumentException('The maxlength value must be a non-negative integer');
        }

        $input->addValidator('FormManager\\Validators\\Maxlength::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(DataElementInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Maxlength::validate');
    }
}
