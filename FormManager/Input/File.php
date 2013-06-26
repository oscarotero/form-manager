<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class File extends Input implements InputInterface {
	public $isFile = true;
	protected $attributes = array('type' => 'file');
}
