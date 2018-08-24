<?php

namespace FormManager\Elements;

use FormManager\InputInterface;

class InputCheckbox extends Input implements InputInterface
{
    protected $attributes = ['type' => 'checkbox', 'value' => 'on'];

    /**
     * {@inheritdoc}
     */
    public function load($value = null)
    {
        if ($this->evalValue($value)) {
            $this->check();
        } else {
            $this->uncheck();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('checked') ? $this->attr('value') : null;
        }

        if ($this->evalValue($value)) {
            $this->check();
        } else {
            $this->uncheck();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        return $this->attr('checked', true);
    }

    /**
     * {@inheritdoc}
     */
    public function uncheck()
    {
        return $this->removeAttribute('checked');
    }

    private function evalValue($value)
    {
        return ((string) $this->attr('value') === (string) $value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
