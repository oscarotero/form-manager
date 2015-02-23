<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Checkbox extends Input implements InputInterface
{
    protected $attributes = ['type' => 'checkbox', 'value' => 'on'];
    protected $labelBefore = false;

    /**
     * {@inheritDoc}
     */
    public function load($value = null, $file = null)
    {
        if (!empty($value) && ($this->attr('value') == $value)) {
            $this->check();
        } else {
            $this->uncheck();
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
