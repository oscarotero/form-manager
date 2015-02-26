<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;

class Pattern implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(InputInterface $input, $value)
    {
        $input->addValidator('FormManager\\Validators\\Pattern::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Pattern::validate');
    }
}
