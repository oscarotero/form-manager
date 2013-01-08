<?php

namespace FormManager;

abstract class Select extends Element {

    public $isFile = false;
    protected $attributes_validators = array();
    protected $value;
    protected $options;
    protected $label;
    protected $error;

    public static function __callStatic($name, $arguments) {
        $class = __NAMESPACE__ . '\\Select\\' . ucfirst($name);

        if (class_exists($class)) {
            return new $class;
        }
    }

    public function __toString() {
        return $this->labelToHtml() . $this->toHtml();
    }

    public function label($label = null) {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    public function error($error = null) {
        if ($error === null) {
            return $this->error;
        }

        if (func_num_args() > 1) {
            $this->error = vsprintf($error, array_slice(func_get_args(), 1));
        } else {
            $this->error = $error;
        }

        return $this;
    }

    public function attr($name, $value = null) {
        if ($name === 'value') {
            return $this->val($value);
        }
        if ($name === 'options' && is_array($value)) {
            return $this->options($value);
        }

        if ($value !== null) {
            $class = 'FormManager\\Attributes\\' . ucfirst($name);

            if (class_exists($class)) {
                if (method_exists($class, 'validate')) {
                    $this->attributes_validators[$name] = array($class, 'validate');
                }

                if (method_exists($class, 'attr')) {
                    $value = call_user_func(array($class, 'attr'), $value);
                }
            }
        }

        return parent::attr($name, $value);
    }

    public function removeAttr($name) {
        parent::removeAttr($name);

        unset($this->validators[$name]);
    }

    public function val($value = null) {
        if ($value === null) {
            return isset($this->value) ? $this->value : null;
        }

        $this->value = $value;

        return $this;
    }

    public function options($value = null) {
        $this->options = $value;

        return $this;
    }

    public function validate() {
        $value = $this->val();

        foreach ($this->attributes_validators as $name => $validator) {
            if (!call_user_func($validator, $value, $this->attributes[$name])) {
                $this->error($validator[0]::$error_message, $this->attributes[$name]);

                return false;
            }
        }

        return true;
    }

    public function toHtml(array $attributes = array()) {
        if ($this->error) {
            if (isset($attributes['class'])) {
                $attributes['class'] .= ' error';
            } else {
                $attributes['class'] = 'error';
            }

            $html = '<select' . static::attrHtml($this->attributes, $attributes) . '>';
            $html .= '<label class="error">' . $this->error . '</label>';
        } else {
            $html = '<select' . static::attrHtml($this->attributes, $attributes) . '>';
            $html .= '<option value="">--</option>';
            foreach ($this->options as $value => $opt) {
                if ($this->value == $value) {
                    $html .= '<option value="' . $value . '" selected>' . $opt . '</option>';
                } else {
                    $html .= '<option value="' . $value . '">' . $opt . '</option>';
                }
            }
            $html .= '</select>';
        }

        return $html;
    }

    public function labelToHtml(array $attributes = array()) {
        if (!$this->attr('id')) {
            $this->attr('id', uniqid('select-'));
        }

        $attributes['for'] = $this->attr('id');

        return '<label' . static::attrHtml($attributes) . '>' . $this->label() . '</label>';
    }

}
