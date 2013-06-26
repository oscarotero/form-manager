<?php
namespace FormManager\Input;

use FormManager\Input;

class Select extends Input {
    protected $options;

    public function options (array $value = null) {
        if ($value === null) {
            return $this->options;
        }

        $this->options = $value;

        return $this;
    }

    public function inputToHtml (array $attributes = null) {
        $html = '<select'.static::attrHtml($this->attributes, $attributes).'>';

        foreach ($this->options as $value => $opt) {
            $html .= '<option'.static::attrHtml(array(
                'value' => $value,
                'selected' => ($this->val() === $value)
            )).'>';

            $html .= $opt.'</option>';
        }

        $html .= '</select>';

        return $html;
    }
}
