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
	
    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'range');
    }
}
