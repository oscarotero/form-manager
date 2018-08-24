<?php

namespace FormManager\Traits;

use FormManager\ValidatorFactory;

/**
 * Common methods for inputs' validators
 */
trait HasValidators
{
	public function getValidator()
    {
    	$validators = self::INTR_VALIDATORS;

    	foreach (self::ATTR_VALIDATORS as $name) {
    		if ($this->getAttribute($name)) {
    			$validators[] = $name;
    		}
    	}

    	return ValidatorFactory::createValidator($this, $validators);
    }

    public function isValid()
    {
    	return $this->getValidator()->validate($this->value);
    }
}