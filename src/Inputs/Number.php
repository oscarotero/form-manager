<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Number extends Input implements FormElementInterface
{
    public static $error_message = 'This value is not a valid number';

    protected $attributes = ['type' => 'number'];

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && (filter_var($value, FILTER_VALIDATE_FLOAT) === false)) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
