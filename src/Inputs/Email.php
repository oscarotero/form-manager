<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Email extends Input implements FormElementInterface
{
    public static $error_message = 'This value is not a valid email';

    protected $attributes = ['type' => 'email'];

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
