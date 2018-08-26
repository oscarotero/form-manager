<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="datetime-local"] element
 */
class DatetimeLocal extends Input
{
	const INTR_VALIDATORS = [
		'datetimeLocal'
	];

	const ATTR_VALIDATORS = [
		// 'step',
		'max',
		'min',
	];
	
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'datetime-local');
    }
}
