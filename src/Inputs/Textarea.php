<?php
namespace FormManager\Inputs;

use FormManager\FormElementInterface;

class Textarea extends Input implements FormElementInterface
{
    protected $name = 'textarea';
    protected $close = true;

    /**
     * {@inheritDoc}
     */
    public function val($value = null)
    {
        if ($value === null) {
            return $this->html;
        }

        $this->html = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function html($html = null)
    {
        if ($html === null) {
            return static::escape($this->html);
        }

        $this->html = $html;

        return $this;
    }
}
