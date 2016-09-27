<?php

namespace FormManager\Attributes;

use FormManager\InputInterface;

class Min extends Max implements AttributeInterface
{

    const VALIDATE_DATE_TIME = "validateDatetimeMin";

    /**
     * Add the validator for this input.
     *
     * @param InputInterface $input
     */
    protected static function addValidator(InputInterface $input)
    {
        $input->addValidator(\FormManager\Validators\Min::class, 'FormManager\\Validators\\Min::validate');
    }

    /**
     * Add the validator for this date-time input.
     *
     * @param InputInterface $input
     */
    protected static function addDatetimeValidator(InputInterface $input)
    {
        $input->addValidator(self::VALIDATE_DATE_TIME, 'FormManager\\Validators\\Min::validateDatetime');
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Min::validateDatetime');
        $input->removeValidator('FormManager\\Validators\\Min::validate');
    }
}
