<?php
namespace FormManager\Fields;

use FormManager\InputInterface;
use FormManager\Inputs\Input;

class Radio extends Field implements InputInterface
{
    public function __construct()
    {
        $this->input = Input::radio();
    }

    /**
     * {@inheritDoc}
     */
    public function toHtml()
    {
        if ($this->render) {
            return parent::toHtml();
        }

        $label = isset($this->label) ? (string) $this->label : '';

        return "{$this->input} {$label} {$this->errorLabel}";
    }
}
