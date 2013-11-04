<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Hidden extends Input implements InputInterface {
	protected $attributes = ['type' => 'hidden'];
}
