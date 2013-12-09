<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Checkbox extends Input implements InputInterface {
	protected $attributes = ['type' => 'checkbox', 'value' => 'on'];

	public function load ($value = null, $file = null) {
		if (!empty($value) && ($this->attributes['value'] == $value)) {
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

	public function check () {
		return $this->attr('checked', true);
	}

	public function uncheck () {
		return $this->removeAttr('checked');
	}
}
