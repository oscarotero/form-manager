<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Range extends Number implements InputInterface {
	protected $attributes = ['type' => 'range'];
}
