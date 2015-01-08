<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Datetime extends Input implements FormElementInterface
{
    public static $error_message = 'This value is not a valid datetime';

    protected static $format = 'Y-m-d\TH:i:sP';

    protected $attributes = ['type' => 'datetime'];

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if ($value) {
            if (!($date = date_create($value))) {
                $this->error(static::$error_message);

                return false;
            }

            $this->val($date->format(static::$format));
        }

        return parent::validate();
    }
}
