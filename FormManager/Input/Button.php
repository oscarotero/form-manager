<?php
namespace FormManager\Input;

use FormManager\Input;

class Button extends Input {
	protected $html = 'Button';
	protected $attributes = array('type' => 'button');

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
}
