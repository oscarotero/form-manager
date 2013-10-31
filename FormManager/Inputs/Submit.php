<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Submit extends Input implements InputInterface {
	protected $attributes = ['type' => 'submit'];
}
