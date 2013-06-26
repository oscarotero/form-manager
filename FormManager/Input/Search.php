<?php
namespace FormManager\Input;

use FormManager\Input;
use FormManager\InputInterface;

class Search extends Text implements InputInterface {
	protected $attributes = array('type' => 'search');
}
