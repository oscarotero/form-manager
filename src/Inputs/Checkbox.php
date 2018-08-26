<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="checkbox"] element
 */
class Checkbox extends Input
{
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'checkbox');
        $this->setAttribute('value', 'on');
    }

    protected function setValue($value)
    {
    	if (
    		((string) $this->getAttribute('value') === (string) $value) || 
    		filter_var($value, FILTER_VALIDATE_BOOLEAN)
    	) {
    		$this->value = true;
    		$this->setAttribute('checked', true);
    		return;
    	}

		$this->value = null;
		$this->removeAttribute('checked');
    }
}
