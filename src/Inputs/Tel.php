<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="tel"] element
 */
class Tel extends Input
{
    const INTR_VALIDATORS = [];

    const ATTR_VALIDATORS = [
        'maxlength',
        'minlength',
        'pattern',
    ];
    
    public function __construct(string $label = null, iterable $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'tel');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
