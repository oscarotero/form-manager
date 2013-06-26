<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Hidden extends Input implements InputInterface {
	protected $inputContainer = '';
	protected $attributes = array('type' => 'hidden');
}
