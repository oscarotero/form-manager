<?php
declare(strict_types = 1);

namespace FormManager\Inputs;

/**
 * Class representing a HTML input[type="date"] element
 */
class Date extends Input
{
    const INTR_VALIDATORS = [
        'date',
    ];

    const ATTR_VALIDATORS = [
        // 'step',
        'max',
        'min',
    ];
    
    public function __construct(string $label = null, array $attributes = [])
    {
        parent::__construct('input', $attributes);
        $this->setAttribute('type', 'date');

        if (isset($label)) {
            $this->setLabel($label);
        }
    }
}
