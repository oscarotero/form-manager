<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Submit extends Input implements InputInterface {
	protected $name = 'button';
	protected $close = true;
	protected $attributes = ['type' => 'submit'];
}
