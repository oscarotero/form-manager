<?php
namespace FormManager\Input;

use FormManager\Input;

class Hidden extends Input {
	protected $attributes = array('type' => 'hidden');

	public function labelToHtml (array $attributes = array()) {
		return '';
	}
}
