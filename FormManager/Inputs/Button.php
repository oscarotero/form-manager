<?php
namespace FormManager\Inputs;

class Button extends Input implements InputInterface {
	protected $name = 'button';
	protected $html = 'Button';
	protected $close = true;
	protected $attributes = ['type' => 'button'];
}
