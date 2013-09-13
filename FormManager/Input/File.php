<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class File extends Input implements InputInterface {
	const IS_FILE = true;

	protected $attributes = array('type' => 'file');
}
