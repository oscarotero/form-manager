<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Color extends Input implements FormElementInterface
{
    public static $error_message = 'This value is not a valid color';

    protected $attributes = ['type' => 'color'];

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && !preg_match('/^#[A-Fa-f0-9]{6}$/', $value)) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
