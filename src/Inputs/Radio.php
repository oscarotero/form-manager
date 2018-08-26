<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="radio"] element
 */
class Radio extends Input
{
	const INTR_VALIDATORS = [];

	const ATTR_VALIDATORS = [
	];
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'radio');
    }
}
