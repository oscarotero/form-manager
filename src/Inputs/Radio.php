<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="radio"] element
 */
class Radio extends Input
{
    public function __construct()
    {
        parent::__construct('input');
        $this->setAttribute('type', 'radio');
    }

    protected function setValue($value)
    {
    	if (!empty($value) && (string) $this->getAttribute('value') === (string) $value) {
    		$this->value = $value;
    		$this->setAttribute('checked', true);
    		return;
    	}

		$this->value = null;
		$this->removeAttribute('checked');
    }
}
