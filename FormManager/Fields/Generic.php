<?php
namespace FormManager\Fields;

use FormManager\InputInterface;

class Generic extends Field implements InputInterface {
	public function __construct (InputInterface $input) {
		$this->input = $input;
	}
}
