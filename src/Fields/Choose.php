<?php
namespace FormManager\Fields;

use FormManager\FormContainerInterface;
use FormManager\FormElementInterface;

class Choose extends Group implements FormContainerInterface, FormElementInterface
{
    public static $error_message = 'This value is not valid';

    /**
     * {@inheritDoc}
     */
    public function prepareChild($child, $key, $parentPath = null)
    {
        if ($child instanceof FormContainerInterface) {
            throw new \Exception("The Choose field cannot have collections inside", 1);
        }

        $child->val($key);
        $child->attr('name', $parentPath);
    }

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        $this->val($value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        foreach ($this as $v => $input) {
            if ($v == $value) {
                $input->check();
            } else {
                $input->uncheck();
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function validate()
    {
        $value = $this->val();

        if (!empty($value) && !isset($this[$value])) {
            $this->error(static::$error_message);

            return false;
        }

        return parent::validate();
    }
}
