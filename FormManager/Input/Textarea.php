<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Textarea extends Input implements InputInterface {
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
