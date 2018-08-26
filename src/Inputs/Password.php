<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="password"] element
 */
class Password extends Input
{
	const INTR_VALIDATORS = [];

	const ATTR_VALIDATORS = [
		'maxlength',
        'minlength',
        'pattern',
	];
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'password');
    }
}
