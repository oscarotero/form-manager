<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputCheckbox extends Input implements DataElementInterface
{
    protected $attributes = ['type' => 'checkbox', 'value' => 'on'];

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return ($this->attr('checked') ? $this->attr('value') : null);
        }

        if (($this->attr('value') == $value) || filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $this->check();
        } else {
            $this->uncheck();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function check()
    {
        return $this->attr('checked', true);
    }

    /**
     * {@inheritDoc}
     */
    public function uncheck()
    {
        return $this->removeAttr('checked');
    }
}
