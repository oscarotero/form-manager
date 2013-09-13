<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Button extends Input implements InputInterface {
	protected $name = 'button';
	protected $attributes = array('type' => 'button');
	protected $html = 'Button';

	public function html ($html = null) {
		if ($html === null) {
			return $this->html;
		}

		$this->html = $html;

		return $this;
	}

	public function inputToHtml (array $attributes = null) {
		return '<button'.static::attrHtml($this->attributes, $attributes).'>'.$this->html().'</button>';
	}

	protected function defaultFnRender ($input, $label, $errorLabel) {
		return $input;
	}
}
