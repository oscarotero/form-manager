<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

class Accept implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(DataElementInterface $input, $value)
    {
        $input->addValidator('FormManager\\Validators\\Accept::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(DataElementInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Accept::validate');
    }
}
