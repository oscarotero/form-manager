<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Radio extends Input implements InputInterface {
	protected $attributes = array('type' => 'radio');
	protected $loaded_value = null;

	public function load ($value = null) {
		$this->loaded_value = $value;

		if (!empty($this->loaded_value) && ($this->attributes['value'] == $this->loaded_value)) {
			$this->attr('checked', true);
		}

		$this->validate();
	}

	public function val ($value = null) {
		if ($value === null) {
			return $this->attr('checked') ? $this->attributes['value'] : null;
		}

		$this->attributes['value'] = $value;
		$this->validate();

		return $this;
	}

	protected function defaultFnRender ($input, $label, $errorLabel) {
		return "$input $label $errorLabel";
	}
}
