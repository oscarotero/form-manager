<?php
namespace FormManager\Input;

use FormManager\Input;

class File extends Input {
	public $isFile = true;
	protected $attributes = array('type' => 'file');
}
