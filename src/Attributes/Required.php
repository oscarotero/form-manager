<?php
namespace FormManager\Attributes;

use FormManager\InputInterface;

class Required
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(InputInterface $input, $value)
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
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Required::validate');
    }
}
