<?php
namespace FormManager\Input;

use FormManager\Input;

class Textarea extends Input {
	protected $attributes = array();
	protected $value;

	public function val ($value = null) {
		if ($value === null) {
			return $this->value;
		}

		$this->value = $value;

		return $this;
	}

	public function inputToHtml (array $attributes = null) {
		if ($this->error) {
			if (isset($attributes['class'])) {
				$attributes['class'] .= ' error';
			} else {
				$attributes['class'] = 'error';
			}

			$html = '<textarea'.static::attrHtml($this->attributes, $attributes).'>'.$this->value.'</textarea>';
			$html .= '<label class="error">'.$this->error.'</label>';
		} else {
			$html = '<textarea'.static::attrHtml($this->attributes, $attributes).'>'.$this->value.'</textarea>';
		}

		return $html;
	}
}
