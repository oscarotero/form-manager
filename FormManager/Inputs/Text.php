<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Text extends Input implements InputInterface {
	protected $attributes = ['type' => 'text'];
}
