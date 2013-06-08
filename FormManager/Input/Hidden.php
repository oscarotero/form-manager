<?php
namespace FormManager\Input;

use FormManager\Input;

class Hidden extends Input {
	protected $inputContainer = '';
	protected $attributes = array('type' => 'hidden');
}
