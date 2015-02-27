<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

class Required
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(DataElementInterface $input, $value)
    {
        if (!is_bool($value)) {
            throw new \InvalidArgumentException('The required value must be a boolean');
        }

        $input->addValidator('FormManager\\Validators\\Required::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(DataElementInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Required::validate');
    }
}
