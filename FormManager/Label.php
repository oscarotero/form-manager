<?php
namespace FormManager;

class Label extends Element {
	protected $name = 'label';
	protected $input;

	public function __construct (Input $input) {
		$this->input = $input;
	}

	public function toHtml (array $attributes = null) {
		$attributes['for'] = $this->input->id();

		return parent::toHtml($attributes);
	}
}
