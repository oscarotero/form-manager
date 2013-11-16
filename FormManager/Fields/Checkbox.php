<?php
namespace FormManager\Fields;

use FormManager\InputInterface;
use FormManager\Inputs\Input;

class Checkbox extends Radio implements InputInterface {
	public function __construct () {
		$this->input = Input::checkbox();
	}
}
