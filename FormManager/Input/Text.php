<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Text extends Input implements InputInterface {
	protected $attributes = array('type' => 'text');
}
