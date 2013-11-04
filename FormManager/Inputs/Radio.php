<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Radio extends Checkbox implements InputInterface {
	protected $attributes = ['type' => 'radio'];
}
