<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="range"] element
 */
class Range extends Input
{
	const INTR_VALIDATORS = [
		'number',
	];

	const ATTR_VALIDATORS = [
		'step',
		'max',
		'min',
	];
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'range');
    }
}
