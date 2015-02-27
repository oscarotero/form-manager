<?php
namespace FormManager\Attributes;

use FormManager\DataElementInterface;

class Min extends Max implements AttributeInterface
{
    /**
     * Add the validator for this input.
     *
     * @param DataElementInterface $input
     */
    protected static function addValidator(DataElementInterface $input)
    {
        $input->addValidator('FormManager\\Validators\\Min::validate');
    }

    /**
     * Add the validator for this date-time input.
     *
     * @param DataElementInterface $input
     */
    protected static function addDatetimeValidator(DataElementInterface $input)
    {
        $input->addValidator('FormManager\\Validators\\Min::validateDatetime');
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(DataElementInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Min::validateDatetime');
        $input->removeValidator('FormManager\\Validators\\Min::validate');
    }
}
