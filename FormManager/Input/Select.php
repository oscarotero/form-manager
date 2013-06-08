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

    public function validate () {
        $value = $this->val();

        foreach ($this->attributes_validators as $name => $validator) {
            if (!call_user_func($validator, $value, $this->attributes[$name])) {
                $this->error($validator[0]::$error_message, $this->attributes[$name]);

                return false;
            }
        }

        return true;
    }

    public function inputToHtml (array $attributes = null) {
        if ($this->error) {
            if (isset($attributes['class'])) {
                $attributes['class'] .= ' error';
            } else {
                $attributes['class'] = 'error';
            }

            $error = '<label class="error">'.$this->error.'</label>';
        } else {
            $error = '';
        }

        $html = '<select'.static::attrHtml($this->attributes, $attributes).'>';

        foreach ($this->options as $value => $opt) {
            $html .= '<option'.static::attrHtml(array(
                'value' => $value,
                'selected' => ($this->val() === $value)
            )).'>';

            $html .= $opt.'</option>';
        }

        $html .= '</select>';

        return $html.$error;
    }
}
