<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="color"] element
 */
class Color extends Input
{
	const INTR_VALIDATORS = [
		'color',
	];

    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'color');
    }
}
