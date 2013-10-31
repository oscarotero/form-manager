<?php
namespace FormManager\Inputs;

use FormManager\InputInterface;

class Button extends Input implements InputInterface {
	protected $name = 'button';
	protected $html = 'Button';
	protected $close = true;
	protected $attributes = ['type' => 'button'];
}
