<?php
namespace FormManager\Input;

use FormManager\Input;

class Checkbox extends Input {
	protected $attributes = array('type' => 'checkbox', 'value' => 'on');
	protected $label_position = Input::LABEL_POSITION_AFTER;
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
}
