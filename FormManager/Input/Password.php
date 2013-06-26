<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Password extends Input implements InputInterface {
	protected $attributes = array('type' => 'password');
}
