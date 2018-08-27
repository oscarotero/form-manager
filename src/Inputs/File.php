<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="file"] element
 */
class File extends Input
{
	const INTR_VALIDATORS = [
		'file'
	];

	const ATTR_VALIDATORS = [
		'accept',
	];
	
    public function __construct(array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'file');
    }
}
