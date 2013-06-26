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
		$this->validate();

		return $this;
	}

	public function inputToHtml (array $attributes = null) {
		return '<textarea'.static::attrHtml($this->attributes, $attributes).'>'.$this->value.'</textarea>';
	}
}
