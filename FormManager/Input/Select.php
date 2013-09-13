<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Select extends Input implements InputInterface {
    protected $name = 'select';
    protected $options;

    public function options (array $value = null) {
        if ($value === null) {
            return $this->options;
        }

        $this->options = $value;

        return $this;
    }

    public function toHtml (array $attributes = null) {
        $html = '<'.$this->name.$this->attrToHtml($attributes).'>';
        $currentVal = $this->val();

        foreach ($this->options as $value => $label) {
            $html .= '<option value="'.static::escape($value).'"';
            
            if ($currentVal === $value) {
                $html .= ' selected';
            }

            $html .= '>'.$label.'</option>';
        }

        return $html.'</'.$this->name.'>';
    }
}
