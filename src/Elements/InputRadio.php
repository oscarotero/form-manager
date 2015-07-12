<?php
namespace FormManager\Elements;

use FormManager\InputInterface;

class InputRadio extends InputCheckbox implements InputInterface
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
            return $this->attr('checked') ? $this->attr('value') : null;
        }

        $this->attr('value', $value);

        return $this;
    }
}
