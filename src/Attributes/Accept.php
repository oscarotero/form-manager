<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;

class Accept implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(InputInterface $input, $value)
    {
        $input->addValidator('FormManager\\Validators\\Accept::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Accept::validate');
    }
}
