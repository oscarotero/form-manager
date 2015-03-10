<?php
namespace FormManager\Elements;

use FormManager\DataElementInterface;

class InputRadio extends InputCheckbox implements DataElementInterface
{
    protected $attributes = ['type' => 'radio'];

    /**
     * {@inheritDoc}
     */
    public function load($value = null)
    {
        if (!empty($value) && ($this->attr('value') == $value)) {
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
            return $this->attr('checked') ? $this->attributes['value'] : null;
        }

        $this->attributes['value'] = $value;

        return $this;
    }
}
