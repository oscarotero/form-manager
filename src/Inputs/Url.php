<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Url extends Input implements InputInterface
{
    public static $error_message = 'This value is not a valid url';

    protected $attributes = ['type' => 'url'];

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
