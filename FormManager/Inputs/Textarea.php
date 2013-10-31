<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Textarea extends Input implements InputInterface {
	protected $name = 'textarea';
	protected $close = true;

	public function val ($value = null) {
		if ($value === null) {
			return $this->html;
		}

		$this->html = $value;

		return $this;
	}

	public function html ($html = null) {
		if ($html === null) {
			return static::escape($this->html);
		}

		$this->html = $html;

		return $this;
	}
}
