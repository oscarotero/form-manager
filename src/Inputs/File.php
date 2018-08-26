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
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'file');
    }
}
