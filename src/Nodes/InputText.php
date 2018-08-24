<?php
declare(strict_types = 1);

namespace FormManager\Nodes;

use Exception;
use FormManager\Traits\HasValidators;

/**
 * Class representing a HTML input[type="text"] element
 */
class InputText extends Node
{
	use HasValidators;

	const INTR_VALIDATORS = [];

	const ATTR_VALIDATORS = [
		'maxlength',
		'pattern',
		'required',
	];

    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'text');
    }
}
