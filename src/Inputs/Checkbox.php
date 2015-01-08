<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Checkbox extends Input implements FormElementInterface
{
    protected $attributes = ['type' => 'checkbox', 'value' => 'on'];

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        if (!empty($value) && ($this->attr('value') == $value)) {
            $this->attr('checked', true);
        }

        $this->validate();
    }

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->attr('checked') ? $this->attributes['value'] : null;
        }

        $this->attributes['value'] = $value;
        $this->validate();

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
