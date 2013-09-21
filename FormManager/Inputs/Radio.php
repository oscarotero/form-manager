<?php
namespace FormManager\Inputs;

class Radio extends Checkbox implements InputInterface {
	protected $attributes = ['type' => 'radio'];
}
