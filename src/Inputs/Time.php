<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="time"] element
 */
class Time extends Input
{
	const INTR_VALIDATORS = [
		'time',
	];

	const ATTR_VALIDATORS = [
		// 'step',
		'max',
		'min',
	];
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'time');
    }
}
