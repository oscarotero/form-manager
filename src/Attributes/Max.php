<?php

namespace FormManager\Attributes;

use FormManager\InputInterface;

class Max implements AttributeInterface
{

    const VALIDATE_DATE_TIME = "validateDatetime";

    /**
     * {@inheritdoc}
     */
    public static function onAdd(InputInterface $input, $value)
    {
        switch ($input->attr('type')) {
            case 'datetime':
            case 'datetime-local':
            case 'date':
            case 'time':
            case 'month':
            case 'week':
                if (!date_create($value)) {
                    throw new \InvalidArgumentException('This attribute must be a valid datetime');
                }

                static::addDatetimeValidator($input);

                return $value;
        }

        if (!is_float($value) && !is_int($value)) {
            throw new \InvalidArgumentException('This attribute must be a float number');
        }

        static::addValidator($input);

        return $value;
    }

    /**
     * Add the validator for this input.
     *
     * @param InputInterface $input
     */
    protected static function addValidator(InputInterface $input)
    {
        $input->addValidator(\FormManager\Validators\Max::class, 'FormManager\\Validators\\Max::validate');
    }

    /**
     * Add the validator for this date-time input.
     *
     * @param InputInterface $input
     */
    protected static function addDatetimeValidator(InputInterface $input)
    {
        $input->addValidator(self::VALIDATE_DATE_TIME,'FormManager\\Validators\\Max::validateDatetime');
    }

    /**
     * {@inheritdoc}
     */
    public static function onRemove(InputInterface $input)
    {
        $input->removeValidator('FormManager\\Validators\\Max::validateDatetime');
        $input->removeValidator('FormManager\\Validators\\Max::validate');
    }
}
