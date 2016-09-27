<?php

namespace FormManager\Attributes;

use FormManager\Fields\Form;
use FormManager\InputInterface;

class Maxlength implements AttributeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function onAdd(InputInterface $input, $value)
    {
        if (!is_int($value) || ($value < 0)) {
            throw new \InvalidArgumentException('The maxlength value must be a non-negative integer');
        }

        $input->addValidator(\FormManager\Validators\Maxlength::class, 'FormManager\\Validators\\Maxlength::validate');

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Maxlength::validate');
    }
}
