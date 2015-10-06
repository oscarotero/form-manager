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
        if (($this->attr('value') == $value) || filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
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
            return ($this->attr('checked') ? $this->attr('value') : null);
        }

        if (((string) $this->attr('value') === (string) $value) || filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
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
        return $this->removeAttr('checked');
    }
}
