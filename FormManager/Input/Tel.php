<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Tel extends Text implements InputInterface {
	protected $attributes = array('type' => 'tel');
}
