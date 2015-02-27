<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

class Pattern implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(DataElementInterface $input, $value)
    {
        $input->addValidator('FormManager\\Validators\\Pattern::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(DataElementInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Pattern::validate');
    }
}
