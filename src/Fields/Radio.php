<?php
namespace FormManager\Fields;

use FormManager\FormElementInterface;
use FormManager\Inputs\Input;

class Radio extends Field implements FormElementInterface
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
        if ($this->render && !$this->rendering) {
            $this->rendering = true;
            $html = call_user_func($this->render, $this);
            $this->rendering = false;

            return $html;
        }

        $label = isset($this->label) ? (string) $this->label : '';

        return "{$this->input} {$label} {$this->errorLabel}";
    }
}
