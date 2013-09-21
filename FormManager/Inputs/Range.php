<?php
namespace FormManager\Inputs;

class Range extends Number implements InputInterface {
	protected $attributes = ['type' => 'range'];
}
