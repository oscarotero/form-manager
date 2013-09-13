<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Textarea extends Input implements InputInterface {
	protected $name = 'textarea';

	public function val ($value = null) {
		if ($value === null) {
			return $this->html;
		}

		$this->html = $value;
		$this->validate();

		return $this;
	}

	public function toHtml (array $attributes = null) {
		return '<'.$this->name.$this->attrToHtml($attributes).'>'.$this->html().'</'.$this->name.'>';
	}

	public function html ($html = null) {
		if ($html === null) {
			return static::escape($this->html);
		}

		$this->html = $html;

		return $this;
	}
}
